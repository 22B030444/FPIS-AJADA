@extends('layouts.app')

@section('content')
    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 200px;
            height: calc(100vh - 60px);
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding-top: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
        }
        .sidebar-item:hover {
            background-color: #efefef;
            cursor: pointer;
        }
        .sidebar-item i {
            font-size: 18px;
            color: #4a4a4a;
        }

        /* Main Content */
        .main-content {
            margin-left: 200px;
            padding: 80px 20px 20px;
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4a4a4a;
        }

        /* Avatar Circle */
        .avatar-circle-big {
            width: 45px;
            height: 45px;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 11px;
        }

        /* Logout */
        .logout-form button {
            background: none;
            border: none;
            color: #333;
            font-size: 0.9rem;
            cursor: pointer;
            gap: 6px;
        }
        .logout-form button:hover {
            text-decoration: underline;
        }

        /* Application Form */
        .housing-form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .housing-form select,
        .housing-form button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .application-container {
            margin-left: 280px;
            margin-top: 50px;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .application-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .application-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4a4a4a;
        }
        .application-box select,
        .application-box button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .application-box button {
            background: #7e57c2;
            color: white;
            border: none;
            cursor: pointer;
        }
        .application-box button:hover {
            background: #6f42c1;
        }

        #housing-sidebar {
            display: none;
        }
        #housing-sidebar.open {
            display: block;
        }
    </style>

    <div class="sidebar">
        <div class="sidebar-item" onclick="toggleSection('news')">
            <i class="fas fa-home"></i>
            <span>Лента</span>
        </div>
        @if(Auth::check() && Auth::user()->role === 'student' && optional(Auth::user()->student)->room_id == null)
            <div class="sidebar-item" onclick="toggleSection('housing')">
                <i class="fas fa-bed"></i>
                <span>Заявка на заселение</span>
            </div>
        @endif
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Купи-Продай</span>
        </div>
    </div>

    <div class="main-content" id="news-section">
        <h2>Новости</h2>
        @isset($newsList)
            @forelse($newsList as $news)
                <div class="news-item">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="News Image">
                    @endif
                    <h3>{{ $news->title }}</h3>
                    <p>{{ $news->content }}</p>
                    <small>{{ $news->created_at->format('d.m.Y H:i') }}</small>
                </div>
            @empty
                <p>Нет новостей</p>
            @endforelse
        @endisset
    </div>

    <div class="application-container" id="housing-sidebar">
        <div class="application-box">
            <h2>Заявка на заселение</h2>
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <label for="building">Выберите корпус:</label>
                <select name="building_id" id="building">
                    <option value="">Выберите корпус</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                    @endforeach
                </select>

                <label for="floor">Выберите этаж:</label>
                <select name="floor" id="floor" disabled>
                    <option value="">Сначала выберите корпус</option>
                </select>

                <label for="room">Выберите комнату:</label>
                <select name="room_id" id="room" disabled>
                    <option value="">Сначала выберите этаж</option>
                </select>

                <button type="submit">Заселиться</button>
            </form>
        </div>
    </div>

    <script>
        function toggleSection(section) {
            const newsSection = document.getElementById('news-section');
            const housingSidebar = document.getElementById('housing-sidebar');

            if (section === 'housing') {
                housingSidebar.classList.add('open');
                newsSection.classList.add('hidden');
            } else {
                housingSidebar.classList.remove('open');
                newsSection.classList.remove('hidden');
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const buildingSelect = document.getElementById("building");
            const floorSelect = document.getElementById("floor");
            const roomSelect = document.getElementById("room");

            async function loadFloors(buildingId) {
                if (!buildingId) {
                    floorSelect.innerHTML = '<option value="">Сначала выберите корпус</option>';
                    floorSelect.disabled = true;
                    return;
                }
                try {
                    const response = await fetch(`/student/personal/floors/${buildingId}`);
                    const data = await response.json();
                    floorSelect.innerHTML = '<option value="">Выберите этаж</option>';
                    if (data.length === 0) {
                        floorSelect.innerHTML = '<option value="">Нет этажей</option>';
                        floorSelect.disabled = true;
                        return;
                    }
                    data.forEach(floor => {
                        floorSelect.innerHTML += `<option value="${floor}">${floor}</option>`;
                    });
                    floorSelect.disabled = false;
                } catch (error) {
                    console.error("Ошибка загрузки этажей:", error);
                }
            }

            async function loadRooms(buildingId, floor) {
                if (!floor) {
                    roomSelect.innerHTML = '<option value="">Сначала выберите этаж</option>';
                    roomSelect.disabled = true;
                    return;
                }
                try {
                    const response = await fetch(`/student/personal/rooms/${buildingId}/${floor}`);
                    const data = await response.json();
                    roomSelect.innerHTML = '<option value="">Выберите комнату</option>';
                    if (data.length === 0) {
                        roomSelect.innerHTML = '<option value="">Нет свободных комнат</option>';
                        roomSelect.disabled = true;
                        return;
                    }
                    data.forEach(room => {
                        roomSelect.innerHTML += `<option value="${room.id}">${room.room_number}</option>`;
                    });
                    roomSelect.disabled = false;
                } catch (error) {
                    console.error("Ошибка загрузки комнат:", error);
                }
            }

            buildingSelect.addEventListener("change", function () {
                const buildingId = this.value;
                loadFloors(buildingId);
                roomSelect.innerHTML = '<option value="">Сначала выберите этаж</option>';
                roomSelect.disabled = true;
            });

            floorSelect.addEventListener("change", function () {
                const buildingId = buildingSelect.value;
                const floor = this.value;
                loadRooms(buildingId, floor);
            });
        });
    </script>
@endsection
