@extends('layouts.app')

@section('title', 'Edit Gedung')
@section('header', 'Edit Gedung')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <div class="max-w-6xl mx-auto">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('admin.buildings.index') }}" class="text-gray-500 hover:text-gray-700">Manajemen
                        Gedung</a></li>
                <li><svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg></li>
                <li><span class="text-gray-900 font-medium">Edit {{ $building->name }}</span></li>
            </ol>
        </nav>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.buildings.update', $building) }}" class="space-y-6"
            x-data="buildingForm()">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">Edit Informasi Gedung</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Gedung <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Lantai <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="total_floors" x-model.number="total_floors" min="1"
                            max="20" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <p class="text-xs text-gray-500 mt-1">Current: {{ $building->total_floors }} lantai. Menambah akan
                            create floor baru, mengurangi akan delete floor terakhir.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bentuk Gedung <span
                                class="text-red-500">*</span></label>
                        <select name="shape_type" x-model="shape_type" @change="updatePreview()" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="rectangle">Rectangle (Persegi Panjang)</option>
                            <option value="square">Square (Persegi)</option>
                            <option value="l_shape">L-Shape</option>
                            <option value="u_shape">U-Shape</option>
                            <option value="custom">Custom SVG Path</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rotasi Gedung</label>
                        <select name="rotation" x-model.number="rotation" @change="updatePreview()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="0">Normal</option>
                            <option value="90">Rotate Right</option>
                            <option value="180">Rotate Down</option>
                            <option value="270">Rotate Left</option>
                        </select>
                    </div>

                    <div x-show="shape_type === 'custom'" x-cloak>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SVG Path <span
                                class="text-red-500">*</span></label>
                        <textarea name="svg_path" x-model="svg_path" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 resize-none font-mono text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lebar (px) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="width" x-model.number="width" @input="updatePreview()"
                                min="0" max="1000" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi (px) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="height" x-model.number="height" @input="updatePreview()"
                                min="0" max="1000" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Posisi X <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="position_x" x-model.number="position_x" min="0"
                                max="1800" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Y <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="position_y" x-model.number="position_y" min="0"
                                max="1200" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Warna Identitas Gedung <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="color" x-model="color" @input="updatePreview()"
                                class="h-10 w-20 border border-gray-300 rounded cursor-pointer p-1">
                            <input type="text" x-model="color" @input="updatePreview()"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 uppercase"
                                placeholder="#000000">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pilih warna unik untuk membedakan gedung ini di peta.</p>
                    </div>

                    <div class="flex space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.buildings.index') }}"
                            class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 text-center transition">Batal</a>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-teal-500 text-white font-medium rounded-lg hover:bg-teal-600 transition shadow-lg hover:shadow-xl">Update
                            Gedung</button>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Live Preview</h2>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs px-3 py-1 bg-teal-100 text-teal-700 rounded-full font-medium">Drag
                                    untuk memindahkan</span>
                                <button type="button" @click="toggleFullscreen()"
                                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors"><svg
                                        class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg></button>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg border-2 border-gray-300 p-4 relative" style="height: 400px;">
                            <svg id="previewSvg" viewBox="0 0 1800 1200" class="w-full h-full"
                                @mousedown="startDrag($event)" @mousemove="drag($event)" @mouseup="stopDrag()"
                                @mouseleave="stopDrag()" style="cursor: grab;">
                                <defs>
                                    <pattern id="previewGrid" width="50" height="50"
                                        patternUnits="userSpaceOnUse">
                                        <path d="M 50 0 L 0 0 0 50" fill="none" stroke="#e5e7eb" stroke-width="1" />
                                    </pattern>
                                </defs>
                                <image href="{{ asset('images/background-map.png') }}" x="0" y="0" width="1800"
                                    height="1200" preserveAspectRatio="xMidYMid slice" opacity="0.5" />

                                @foreach ($existingBuildings as $existingBuilding)
                                    <g opacity="0.6">
                                        @if ($existingBuilding->rotation > 0)
                                            <g
                                                transform="rotate({{ $existingBuilding->rotation }} {{ $existingBuilding->position_x + $existingBuilding->width / 2 }} {{ $existingBuilding->position_y + $existingBuilding->height / 2 }})">
                                                <path d="{{ $existingBuilding->generateSvgPath() }}"
                                                    fill="{{ $existingBuilding->color }}" stroke="#000000"
                                                    stroke-width="2" stroke-dasharray="8,4" />
                                            </g>
                                        @else
                                            <path d="{{ $existingBuilding->generateSvgPath() }}"
                                                fill="{{ $existingBuilding->color }}" stroke="#000000" stroke-width="2"
                                                stroke-dasharray="8,4" />
                                        @endif
                                        <text x="{{ $existingBuilding->position_x + $existingBuilding->width / 2 }}"
                                            y="{{ $existingBuilding->position_y + $existingBuilding->height / 2 }}"
                                            text-anchor="middle" class="text-xs" fill="#000000" opacity="0.7"
                                            style="pointer-events: none;">{{ $existingBuilding->name }}</text>
                                    </g>
                                @endforeach

                                <g id="buildingPreview" :style="isDragging ? 'cursor: grabbing;' : 'cursor: grab;'">
                                    <g id="buildingShape"
                                        :transform="rotation > 0 ?
                                            `rotate(${rotation} ${position_x + width/2} ${position_y + height/2})` : ''">
                                        <path id="buildingPath" :d="previewPath" :fill="color"
                                            stroke="#000000" stroke-width="3" />
                                        <path :d="previewPath" fill="none" stroke="#ffffff" stroke-width="2"
                                            stroke-dasharray="5,5" opacity="0.5" />
                                    </g>
                                    <text id="buildingLabel" :x="position_x + width / 2" :y="position_y + height / 2"
                                        text-anchor="middle" class="text-sm font-bold" fill="#000000" stroke="white"
                                        stroke-width="3" paint-order="stroke" style="pointer-events: none;"
                                        x-text="name || 'Gedung Baru'"></text>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>

                <div x-show="isFullscreen" x-cloak
                    class="fixed inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center p-4"
                    @click.self="toggleFullscreen()">
                    <div class="bg-white rounded-xl shadow-2xl w-full h-full max-w-[95vw] max-h-[95vh] flex flex-col">
                        <div class="flex items-center justify-between p-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Live Preview - Fullscreen Mode</h3>
                            <button type="button" @click="toggleFullscreen()"
                                class="p-2 hover:bg-gray-100 rounded-lg transition-colors"><svg
                                    class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg></button>
                        </div>
                        <div class="flex-1 p-6 overflow-hidden">
                            <div class="bg-gray-50 rounded-lg border-2 border-gray-300 h-full">
                                <svg id="previewSvgFullscreen" viewBox="0 0 1800 1200" class="w-full h-full"
                                    @mousedown="startDrag($event)" @mousemove="drag($event)" @mouseup="stopDrag()"
                                    @mouseleave="stopDrag()" style="cursor: grab;">
                                    <defs>
                                        <pattern id="previewGridFull" width="50" height="50"
                                            patternUnits="userSpaceOnUse">
                                            <path d="M 50 0 L 0 0 0 50" fill="none" stroke="#e5e7eb"
                                                stroke-width="1" />
                                        </pattern>
                                    </defs>
                                    <image href="{{ asset('images/background-map.png') }}" x="0" y="0" width="1800"
                                        height="1200" preserveAspectRatio="xMidYMid slice" opacity="0.5" />
                                    @foreach ($existingBuildings as $existingBuilding)
                                        <g opacity="0.6">
                                            @if ($existingBuilding->rotation > 0)
                                                <g
                                                    transform="rotate({{ $existingBuilding->rotation }} {{ $existingBuilding->position_x + $existingBuilding->width / 2 }} {{ $existingBuilding->position_y + $existingBuilding->height / 2 }})">
                                                    <path d="{{ $existingBuilding->generateSvgPath() }}"
                                                        fill="{{ $existingBuilding->color }}" stroke="#000000"
                                                        stroke-width="2" stroke-dasharray="8,4" />
                                                </g>
                                            @else
                                                <path d="{{ $existingBuilding->generateSvgPath() }}"
                                                    fill="{{ $existingBuilding->color }}" stroke="#000000"
                                                    stroke-width="2" stroke-dasharray="8,4" />
                                            @endif
                                            <text x="{{ $existingBuilding->position_x + $existingBuilding->width / 2 }}"
                                                y="{{ $existingBuilding->position_y + $existingBuilding->height / 2 }}"
                                                text-anchor="middle" class="text-xs" fill="#000000" opacity="0.7"
                                                style="pointer-events: none;">{{ $existingBuilding->name }}</text>
                                        </g>
                                    @endforeach
                                    <g id="buildingPreviewFull"
                                        :style="isDragging ? 'cursor: grabbing;' : 'cursor: grab;'">
                                        <g id="buildingShapeFull"
                                            :transform="rotation > 0 ?
                                                `rotate(${rotation} ${position_x + width/2} ${position_y + height/2})` :
                                                ''">
                                            <path :d="previewPath" :fill="color" stroke="#000000"
                                                stroke-width="3" />
                                            <path :d="previewPath" fill="none" stroke="#ffffff"
                                                stroke-width="2" stroke-dasharray="5,5" opacity="0.5" />
                                        </g>
                                        <text :x="position_x + width / 2" :y="position_y + height / 2"
                                            text-anchor="middle" class="text-sm font-bold" fill="#000000" stroke="white"
                                            stroke-width="3" paint-order="stroke" style="pointer-events: none;"
                                            x-text="name || 'Gedung Baru'"></text>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function buildingForm() {
            return {
                name: '{{ old('name', $building->name) }}',
                total_floors: {{ old('total_floors', $building->total_floors) }},
                shape_type: '{{ old('shape_type', $building->shape_type) }}',
                svg_path: `{!! old('svg_path', $building->svg_path) !!}`,
                width: {{ old('width', $building->width) }},
                height: {{ old('height', $building->height) }},
                position_x: {{ old('position_x', $building->position_x) }},
                position_y: {{ old('position_y', $building->position_y) }},
                color: '{{ old('color', $building->color) }}', 
                rotation: {{ old('rotation', $building->rotation ?? 0) }},
                previewPath: '',
                isDragging: false,
                dragOffsetX: 0,
                dragOffsetY: 0,
                isFullscreen: false,

                init() {
                    this.updatePreview();
                },
                toggleFullscreen() {
                    this.isFullscreen = !this.isFullscreen;
                    if (this.isFullscreen) document.body.style.overflow = 'hidden';
                    else document.body.style.overflow = '';
                },
                updatePreview() {
                    const w = this.width,
                        h = this.height,
                        x = this.position_x,
                        y = this.position_y;
                    switch (this.shape_type) {
                        case 'rectangle':
                        case 'square':
                            this.previewPath = `M ${x} ${y} L ${x + w} ${y} L ${x + w} ${y + h} L ${x} ${y + h} Z`;
                            break;
                        case 'l_shape':
                            const lW = w * 0.4,
                                lH = h * 0.6;
                            this.previewPath =
                                `M ${x} ${y} L ${x + w} ${y} L ${x + w} ${y + lH} L ${x + lW} ${y + lH} L ${x + lW} ${y + h} L ${x} ${y + h} Z`;
                            break;
                        case 'u_shape':
                            const iW = w * 0.3,
                                iH = h * 0.5;
                            this.previewPath =
                                `M ${x} ${y} L ${x + w} ${y} L ${x + w} ${y + h} L ${x + w - (w * 0.35)} ${y + h} L ${x + w - (w * 0.35)} ${y + iH} L ${x + (w * 0.35)} ${y + iH} L ${x + (w * 0.35)} ${y + h} L ${x} ${y + h} Z`;
                            break;
                        case 'custom':
                            this.previewPath = this.svg_path ||
                                `M ${x} ${y} L ${x + w} ${y} L ${x + w} ${y + h} L ${x} ${y + h} Z`;
                            break;
                    }
                },
                startDrag(e) {
                    const svg = e.target.closest('svg');
                    if (!svg) return;
                    const pt = svg.createSVGPoint();
                    pt.x = e.clientX;
                    pt.y = e.clientY;
                    const svgP = pt.matrixTransform(svg.getScreenCTM().inverse());
                    if (svgP.x >= this.position_x && svgP.x <= this.position_x + this.width && svgP.y >= this.position_y &&
                        svgP.y <= this.position_y + this.height) {
                        this.isDragging = true;
                        this.dragOffsetX = svgP.x - this.position_x;
                        this.dragOffsetY = svgP.y - this.position_y;
                        e.preventDefault();
                    }
                },
                drag(e) {
                    if (!this.isDragging) return;
                    const svg = e.target.closest('svg');
                    if (!svg) return;
                    const pt = svg.createSVGPoint();
                    pt.x = e.clientX;
                    pt.y = e.clientY;
                    const svgP = pt.matrixTransform(svg.getScreenCTM().inverse());
                    let nX = svgP.x - this.dragOffsetX;
                    let nY = svgP.y - this.dragOffsetY;
                    nX = Math.max(0, Math.min(nX, 1800 - this.width));
                    nY = Math.max(0, Math.min(nY, 1200 - this.height));
                    this.position_x = Math.round(nX);
                    this.position_y = Math.round(nY);
                    this.updatePreview();
                },
                stopDrag() {
                    this.isDragging = false;
                }
            }
        }
    </script>
@endsection
