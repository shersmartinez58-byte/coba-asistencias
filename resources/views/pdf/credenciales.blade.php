<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales COBAO</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        .grid { width: 100%; }
        .credencial {
            width: 100%;
            height: 220px;
            box-sizing: border-box;
            padding: 10px;
            page-break-inside: avoid;
        }
        .card {
            border: 2px solid #047857;
            border-radius: 10px;
            width: 100%;
            height: 200px;
            position: relative;
        }
        .info {
            position: absolute;
            top: 0;
            left: 0;
            width: 70%;
            padding: 20px;
        }
        .qr {
            position: absolute;
            top: 0;
            right: 0;
            width: 30%;
            height: 100%;
            background: #f0fdf4;
            border-left: 2px dashed #047857;
            text-align: center;
            padding-top: 30px;
        }
        .escuela { font-size: 12px; color: #047857; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;}
        .nombre { font-size: 20px; font-weight: bold; margin: 0 0 10px 0; line-height: 1.2; }
        .matricula { font-size: 14px; color: #333; margin-bottom: 5px; }
        .grupo { font-size: 14px; color: #666; margin-bottom: 10px; }
        .footer { font-size: 10px; color: #999; position: absolute; bottom: 15px; left: 20px; }
    </style>
</head>
<body>
    <div class="grid">
        @foreach ($credenciales as $item)
            <div class="credencial">
                <div class="card">
                    <div class="info">
                        <div class="escuela">COBAO Plantel 01</div>
                        <div class="nombre">{{ $item["estudiante"]->nombre_completo }}</div>
                        <div class="matricula">Matrícula: <strong>{{ $item["estudiante"]->matricula }}</strong></div>
                        <div class="grupo">Semestre: {{ $item["estudiante"]->semestre }}° {{ $item["estudiante"]->grupo }} ({{ $item["estudiante"]->turno }})</div>
                        <div class="footer">Vigente 2025-2026</div>
                    </div>
                    <div class="qr">
                        <img src="data:image/png;base64,{{ $item["qr_base64"] }}" width="120" height="120" alt="QR">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
