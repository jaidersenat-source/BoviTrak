@props(["animal", "record", "padres", "madres", "action", "method" ])

<form method="POST" action="{{ $action }}">
    @csrf
    @if(in_array(strtoupper($method), ['PUT','PATCH','DELETE']))
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="text-sm font-semibold text-gray-600">Padre (Toro)</label>
            <select name="padre_id" class="input-bovi w-full mt-1">
                <option value="">-- Selecciona un toro --</option>
                @foreach($padres as $p)
                    <option value="{{ $p->id }}" {{ (string) old('padre_id', $record->padre_id) === (string) $p->id ? 'selected' : '' }}>
                        {{ $p->nombre ? $p->nombre . ' (' . $p->codigo_nfc . ')' : $p->codigo_nfc }}
                    </option>
                @endforeach
            </select>
            @error('padre_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <p class="text-xs text-gray-500 mt-2">Si el padre no está registrado (ej. embrión), puedes ingresar nombre o raza abajo.</p>
            <div class="grid grid-cols-2 gap-2 mt-2">
                <input type="text" name="padre_nombre" placeholder="Nombre del padre (opcional)" value="{{ old('padre_nombre', $record->padre_nombre ?? '') }}" class="input-bovi">
                <input type="text" name="padre_raza" placeholder="Raza del padre (opcional)" value="{{ old('padre_raza', $record->padre_raza ?? '') }}" class="input-bovi">
            </div>
            @error('padre_nombre')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            @error('padre_raza')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Madre (Vaca)</label>
            <select name="madre_id" class="input-bovi w-full mt-1">
                <option value="">-- Selecciona una vaca --</option>
                @foreach($madres as $m)
                    <option value="{{ $m->id }}" {{ (string) old('madre_id', $record->madre_id) === (string) $m->id ? 'selected' : '' }}>
                        {{ $m->nombre ? $m->nombre . ' (' . $m->codigo_nfc . ')' : $m->codigo_nfc }}
                    </option>
                @endforeach
            </select>
            @error('madre_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <p class="text-xs text-gray-500 mt-2">Si la madre no está registrada (ej. embrión), puedes ingresar nombre o raza abajo.</p>
            <div class="grid grid-cols-2 gap-2 mt-2">
                <input type="text" name="madre_nombre" placeholder="Nombre de la madre (opcional)" value="{{ old('madre_nombre', $record->madre_nombre ?? '') }}" class="input-bovi">
                <input type="text" name="madre_raza" placeholder="Raza de la madre (opcional)" value="{{ old('madre_raza', $record->madre_raza ?? '') }}" class="input-bovi">
            </div>
            @error('madre_nombre')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            @error('madre_raza')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', optional($record->fecha_nacimiento)->format('Y-m-d')) }}" class="input-bovi w-full mt-1">
            @error('fecha_nacimiento')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-gray-600">Observaciones</label>
            <textarea name="observaciones" rows="4" class="input-bovi w-full mt-1">{{ old('observaciones', $record->observaciones) }}</textarea>
            @error('observaciones')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between mt-3">
            <a href="{{ route('admin.ganado.show', $animal) }}" class="text-sm text-gray-500 hover:underline">Cancelar</a>
            <button type="submit" class="btn-bovi-gradient px-5 py-2.5 rounded-lg text-sm font-bold">Guardar</button>
        </div>
    </div>
</form>
