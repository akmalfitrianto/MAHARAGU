@extends('layouts.app')

@section('title', 'Edit Access Point')
@section('header', 'Edit Access Point')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('admin.buildings.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen Gedung</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.buildings.show', $accessPoint->room->floor->building) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->floor->building->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.floors.rooms.index', $accessPoint->room->floor) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->floor->display_name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="{{ route('admin.rooms.access-points.index', $accessPoint->room) }}" class="text-gray-500 hover:text-gray-700">{{ $accessPoint->room->name }}</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium">Edit {{ $accessPoint->name }}</span>
            </li>
        </ol>
    </nav>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- AP Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $accessPoint->tickets()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Open Tickets</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $accessPoint->openTickets()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Resolved</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $accessPoint->tickets()->where('status', 'resolved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning if has open tickets -->
    @if($accessPoint->openTickets()->count() > 0)
    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="text-sm text-yellow-800">
                <p class="font-medium mb-1">Perhatian:</p>
                <p class="text-xs">Access Point ini memiliki {{ $accessPoint->openTickets()->count() }} open ticket. Pertimbangkan untuk menyelesaikan ticket terlebih dahulu sebelum mengubah status.</p>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.access-points.update', $accessPoint) }}" class="space-y-6" x-data="accessPointEditForm()">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900">Edit Informasi Access Point</h2>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Access Point <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           x-model="name"
                           value="{{ old('name', $accessPoint->name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status"
                            x-model="status"
                            @change="updatePreview()"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="active">Normal</option>
                        <option value="offline">Bermasalah</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>

                <!-- Position -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="position_x" class="block text-sm font-medium text-gray-700 mb-2">
                            Posisi X <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="position_x" 
                               id="position_x"
                               x-model.number="position_x"
                               value="{{ old('position_x', $accessPoint->position_x) }}"
                               min="0"
                               max="{{ $accessPoint->room->width }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <p class="text-xs text-gray-500 mt-1">Max: {{ $accessPoint->room->width }}</p>
                    </div>
                    <div>
                        <label for="position_y" class="block text-sm font-medium text-gray-700 mb-2">
                            Posisi Y <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="position_y" 
                               id="position_y"
                               x-model.number="position_y"
                               value="{{ old('position_y', $accessPoint->position_y) }}"
                               min="0"
                               max="{{ $accessPoint->room->height }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <p class="text-xs text-gray-500 mt-1">Max: {{ $accessPoint->room->height }}</p>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                        <span class="text-gray-500 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="notes" 
                              id="notes"
                              x-model="notes"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 resize-none">{{ old('notes', $accessPoint->notes) }}</textarea>
                </div>

                <!-- Location Info -->
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm font-medium text-gray-700 mb-2">Lokasi:</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Gedung:</span> {{ $accessPoint->room->floor->building->name }}</p>
                        <p><span class="font-medium">Lantai:</span> {{ $accessPoint->room->floor->display_name }}</p>
                        <p><span class="font-medium">Ruangan:</span> {{ $accessPoint->room->name }}</p>
                        <p><span class="font-medium">Dibuat:</span> {{ $accessPoint->created_at->format('d M Y H:i') }}</p>
                        <p><span class="font-medium">Terakhir Update:</span> {{ $accessPoint->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.rooms.access-points.index', $accessPoint->room) }}" 
                       class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-center transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl">
                        Update Access Point
                    </button>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Live Preview</h2>
                        <span class="text-xs px-3 py-1 bg-teal-100 text-teal-700 rounded-full font-medium">
                            Klik dan Drag AP untuk memindahkan
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg border-2 border-gray-300 p-4" style="height: 500px;">
                        <svg id="previewCanvas" viewBox="0 0 {{ $accessPoint->room->width + 40 }} {{ $accessPoint->room->height + 40 }}" 
                             class="w-full h-full"
                             @mousedown="startDrag($event)" 
                             @mousemove="drag($event)" 
                             @mouseup="stopDrag()"
                             @mouseleave="stopDrag()"
                             :style="isDragging ? 'cursor: grabbing;' : 'cursor: grab;'">
                            <!-- Grid Background -->
                            <defs>
                                <pattern id="previewGrid" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <path d="M 20 0 L 0 0 0 20" fill="none" stroke="#e5e7eb" stroke-width="0.5" />
                                </pattern>
                                
                                <!-- Glow filter for AP -->
                                <filter id="glow">
                                    <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                                    <feMerge>
                                        <feMergeNode in="coloredBlur"/>
                                        <feMergeNode in="SourceGraphic"/>
                                    </feMerge>
                                </filter>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#previewGrid)" />

                            <!-- Room Shape -->
                            <rect x="20" 
                                  y="20" 
                                  width="{{ $accessPoint->room->width }}" 
                                  height="{{ $accessPoint->room->height }}" 
                                  fill="{{ $accessPoint->room->color }}" 
                                  stroke="#6b7280" 
                                  stroke-width="2" 
                                  opacity="0.7" />

                            <!-- Room Border -->
                            <rect x="20" 
                                  y="20" 
                                  width="{{ $accessPoint->room->width }}" 
                                  height="{{ $accessPoint->room->height }}" 
                                  fill="none" 
                                  stroke="#14b8a6" 
                                  stroke-width="2" 
                                  stroke-dasharray="5,5" 
                                  opacity="0.5" />

                            <!-- Other Access Points (excluding current) -->
                            @foreach($accessPoint->room->accessPoints->where('id', '!=', $accessPoint->id) as $ap)
                                <g opacity="0.4">
                                    <circle cx="{{ 20 + $ap->position_x }}" 
                                            cy="{{ 20 + $ap->position_y }}" 
                                            r="5" 
                                            fill="{{ $ap->status_color }}" 
                                            stroke="#ffffff" 
                                            stroke-width="1.5"
                                            style="pointer-events: none;" />
                                    
                                    <text x="{{ 20 + $ap->position_x }}" 
                                          y="{{ 20 + $ap->position_y - 8 }}" 
                                          text-anchor="middle" 
                                          font-size="8"
                                          fill="#9ca3af"
                                          style="pointer-events: none;">
                                        {{ Str::limit($ap->name, 10, '...') }}
                                    </text>
                                </g>
                            @endforeach

                            <!-- Current Access Point (Editing) -->
                            <g id="editingAccessPoint">
                                <!-- Pulse Animation -->
                                <circle :cx="20 + position_x" 
                                        :cy="20 + position_y" 
                                        r="15" 
                                        :fill="statusColor" 
                                        opacity="0.2"
                                        style="pointer-events: none;">
                                    <animate attributeName="r" 
                                             from="15" 
                                             to="25" 
                                             dur="1.5s" 
                                             repeatCount="indefinite"/>
                                    <animate attributeName="opacity" 
                                             from="0.2" 
                                             to="0" 
                                             dur="1.5s" 
                                             repeatCount="indefinite"/>
                                </circle>

                                <!-- Main AP Circle (draggable) -->
                                <circle :cx="20 + position_x" 
                                        :cy="20 + position_y" 
                                        r="8" 
                                        :fill="statusColor" 
                                        stroke="#ffffff" 
                                        stroke-width="2"
                                        filter="url(#glow)" />

                                <!-- AP Label -->
                                <text :x="20 + position_x" 
                                      :y="20 + position_y + 18" 
                                      text-anchor="middle" 
                                      font-size="10"
                                      font-weight="bold"
                                      :fill="statusColor"
                                      x-text="name"
                                      style="pointer-events: none;">
                                </text>

                                <!-- Coordinates -->
                                <text :x="20 + position_x" 
                                      :y="20 + position_y + 28" 
                                      text-anchor="middle" 
                                      font-size="8"
                                      fill="#6b7280"
                                      x-text="`(${position_x}, ${position_y})`"
                                      style="pointer-events: none;">
                                </text>
                            </g>

                            <!-- Coordinate Labels -->
                            <text x="10" y="15" class="text-xs font-medium" fill="#6b7280">0,0</text>
                            <text x="{{ 20 + $accessPoint->room->width }}" y="15" class="text-xs" fill="#6b7280">{{ $accessPoint->room->width }},0</text>
                            <text x="10" y="{{ 20 + $accessPoint->room->height }}" class="text-xs" fill="#6b7280">0,{{ $accessPoint->room->height }}</text>
                        </svg>
                    </div>

                    <!-- Context Info -->
                    <div class="mt-4 space-y-3">
                        <!-- Before/After Comparison -->
                        <div class="p-3 bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-lg">
                            <p class="text-xs font-medium text-gray-700 mb-2">Perubahan:</p>
                            <div class="space-y-1 text-xs text-gray-600">
                                <div class="flex justify-between">
                                    <span>Posisi:</span>
                                    <span class="font-medium" 
                                          :class="(position_x !== {{ $accessPoint->position_x }} || position_y !== {{ $accessPoint->position_y }}) ? 'text-blue-600' : ''">
                                        ({{ $accessPoint->position_x }}, {{ $accessPoint->position_y }}) 
                                        <span x-show="position_x !== {{ $accessPoint->position_x }} || position_y !== {{ $accessPoint->position_y }}">
                                            → (<span x-text="position_x"></span>, <span x-text="position_y"></span>)
                                        </span>
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Status:</span>
                                    <span class="font-medium" 
                                          :class="status !== '{{ $accessPoint->status }}' ? 'text-blue-600' : ''">
                                        {{ ucfirst($accessPoint->status) }}
                                        <span x-show="status !== '{{ $accessPoint->status }}'">
                                            → <span x-text="status.charAt(0).toUpperCase() + status.slice(1)"></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Position Info -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-xs text-blue-800">
                                <strong>Current Position:</strong><br>
                                X: <span x-text="position_x"></span> px,
                                Y: <span x-text="position_y"></span> px<br>
                                <strong>Status:</strong>
                                <span x-text="status === 'active' ? 'Active' : status === 'offline' ? 'Offline' : 'Maintenance'"></span>
                            </p>
                        </div>

                        <!-- Status Legend -->
                        <div class="p-4 bg-white border border-gray-200 rounded-lg">
                            <p class="text-xs font-medium text-gray-700 mb-2">Status Legend:</p>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                    <span class="text-gray-600">Normal</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                    <span class="text-gray-600">Bermasalah</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                    <span class="text-gray-600">Maintenance</span>
                                </div>
                            </div>
                        </div>

                        <!-- Current Status Display -->
                        <div class="p-4 border rounded-lg" 
                             :class="{
                                 'bg-green-50 border-green-200': status === 'active',
                                 'bg-red-50 border-red-200': status === 'offline',
                                 'bg-yellow-50 border-yellow-200': status === 'maintenance'
                             }">
                            <p class="text-xs font-medium mb-1"
                               :class="{
                                   'text-green-800': status === 'active',
                                   'text-red-800': status === 'offline',
                                   'text-yellow-800': status === 'maintenance'
                               }">
                                Current Status:
                            </p>
                            <p class="text-sm font-bold"
                               :class="{
                                   'text-green-900': status === 'active',
                                   'text-red-900': status === 'offline',
                                   'text-yellow-900': status === 'maintenance'
                               }"
                               x-text="status === 'active' ? 'Normal' : status === 'offline' ? 'Bermasalah' : 'Maintenance'">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function accessPointEditForm() {
        return {
            name: '{{ old('name', $accessPoint->name) }}',
            status: '{{ old('status', $accessPoint->status) }}',
            position_x: {{ old('position_x', $accessPoint->position_x) }},
            position_y: {{ old('position_y', $accessPoint->position_y) }},
            notes: `{{ old('notes', $accessPoint->notes) }}`,
            statusColor: '{{ $accessPoint->status_color }}',

            // Drag state
            isDragging: false,
            dragOffsetX: 0,
            dragOffsetY: 0,

            // Room dimensions
            roomWidth: {{ $accessPoint->room->width }},
            roomHeight: {{ $accessPoint->room->height }},
            margin: 20,

            init() {
                this.updatePreview();
            },

            updatePreview() {
                this.statusColor = this.getStatusColor();
            },

            getStatusColor() {
                switch(this.status) {
                    case 'active':
                        return '#22c55e';
                    case 'offline':
                        return '#ef4444';
                    case 'maintenance':
                        return '#eab308';
                    default:
                        return '#6b7280';
                }
            },

            startDrag(event) {
                const svg = document.getElementById('previewCanvas');
                const rect = svg.getBoundingClientRect();
                const viewBoxWidth = this.roomWidth + 40;
                const viewBoxHeight = this.roomHeight + 40;

                // Convert mouse position to SVG coordinates
                const svgX = ((event.clientX - rect.left) / rect.width) * viewBoxWidth;
                const svgY = ((event.clientY - rect.top) / rect.height) * viewBoxHeight;

                // Calculate AP position in SVG coordinates (with margin offset)
                const apCenterX = this.margin + this.position_x;
                const apCenterY = this.margin + this.position_y;

                // Check if click is within AP circle (radius = 8)
                const distance = Math.sqrt(
                    Math.pow(svgX - apCenterX, 2) + 
                    Math.pow(svgY - apCenterY, 2)
                );

                if (distance <= 8) {
                    this.isDragging = true;
                    this.dragOffsetX = svgX - apCenterX;
                    this.dragOffsetY = svgY - apCenterY;
                    event.preventDefault();
                }
            },

            drag(event) {
                if (!this.isDragging) return;

                const svg = document.getElementById('previewCanvas');
                const rect = svg.getBoundingClientRect();
                const viewBoxWidth = this.roomWidth + 40;
                const viewBoxHeight = this.roomHeight + 40;

                // Convert mouse position to SVG coordinates
                let svgX = ((event.clientX - rect.left) / rect.width) * viewBoxWidth;
                let svgY = ((event.clientY - rect.top) / rect.height) * viewBoxHeight;

                // Calculate new position with offset (remove margin to get room-relative position)
                let newX = svgX - this.dragOffsetX - this.margin;
                let newY = svgY - this.dragOffsetY - this.margin;

                // Constrain to room bounds
                newX = Math.max(0, Math.min(newX, this.roomWidth));
                newY = Math.max(0, Math.min(newY, this.roomHeight));

                // Round to nearest integer for cleaner values
                this.position_x = Math.round(newX);
                this.position_y = Math.round(newY);
            },

            stopDrag() {
                this.isDragging = false;
            }
        }
    }
</script>
@endsection