<x-filament-panels::page>
    <div class="prose dark:prose-invert">
        <p>Genera un archivo PDF con las credenciales de todos los alumnos activos. Cada credencial incluye el código QR que utilizarán en los kioscos de asistencia.</p>
        <p class="text-sm text-gray-500">Nota: Si tienes muchos alumnos, la generación del PDF puede tardar unos segundos.</p>
    </div>

    <div class="mt-6 flex gap-4">
        <x-filament::button
            tag="a"
            href="/credenciales"
            target="_blank"
            icon="heroicon-o-printer"
            size="lg"
        >
            Generar PDF de todos los alumnos
        </x-filament::button>
    </div>
</x-filament-panels::page>
