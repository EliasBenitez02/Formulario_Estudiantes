<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-4">Mis Datos</h2>

    <div class="flex items-center mb-6">
        <img src="https://ui-avatars.com/api/?name={{ $user->name }}" 
             class="w-20 h-20 rounded-full border shadow">
        <div class="ml-4">
            <p class="text-xl font-semibold">{{ $user->name }}</p>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div><strong>WhatsApp:</strong> {{ $user->whatsapp }}</div>
        <div><strong>Comisión:</strong> {{ $user->comision }}</div>
        <div><strong>DNI:</strong> {{ $user->dni }}</div>
        <div><strong>Carrera:</strong> {{ $user->carrera }}</div>
        <div><strong>Fecha Nacimiento:</strong> {{ $user->fecha_nacimiento }}</div>
    </div>

    <h3 class="mt-6 font-bold">Redes sociales</h3>
    <div class="flex gap-4">
        @if($user->linkedin)
            <a href="{{ $user->linkedin }}" target="_blank" class="text-blue-600">LinkedIn</a>
        @endif
        @if($user->github)
            <a href="{{ $user->github }}" target="_blank" class="text-gray-700">GitHub</a>
        @endif
    </div>
</div>
