<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Socios - ASODAT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .info-item {
            font-weight: bold;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
            font-size: 11px;
        }
        
        td {
            font-size: 10px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-primary {
            background-color: #007bff;
            color: white;
        }
        
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        @page {
            margin: 15mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ASOCIACIÓN DE DOCENTES Y TRABAJADORES DE LA UNIVERSIDAD DE LAS FUERZAS ARMADAS ESPE</h1>
        <p><strong>ASODAT</strong></p>
        <p>Lista Oficial de Socios</p>
    </div>

    <div class="info-section">
        <div>
            <span class="info-item">Fecha de Generación:</span> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
        <div>
            <span class="info-item">Total de Socios:</span> {{ $socios->count() }}
        </div>
    </div>

    <div class="summary">
        <h3>Resumen por Tipo de Usuario</h3>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Fundadores:</strong> {{ $socios->where('tipo_usuario', 'fundador')->count() }}
            </div>
            <div>
                <strong>Adherentes:</strong> {{ $socios->where('tipo_usuario', 'adherente')->count() }}
            </div>
        </div>
        <div style="margin-top: 10px; display: flex; justify-content: space-between;">
            <div>
                <strong>Campus Belisario Quevedo:</strong> {{ $socios->where('campus', 'BELISARIO')->count() }}
            </div>
            <div>
                <strong>Campus Latacunga Centro:</strong> {{ $socios->where('campus', 'CENTRO')->count() }}
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 12%;">Cédula</th>
                    <th style="width: 25%;">Nombre Completo</th>
                    <th style="width: 20%;">Correo Electrónico</th>
                    <th style="width: 12%;">Campus</th>
                    <th style="width: 10%;">Tipo Usuario</th>
                    <th style="width: 8%;">Fecha Afiliación</th>
                    <th style="width: 8%;">Roles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($socios as $index => $socio)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $socio->cedula ?? 'N/A' }}</td>
                    <td><strong>{{ $socio->apellidos_nombres ?? 'N/A' }}</strong></td>
                    <td>{{ $socio->correo ?? 'N/A' }}</td>
                    <td>{{ $socio->campus ?? 'N/A' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $socio->tipo_usuario === 'fundador' ? 'badge-primary' : 'badge-secondary' }}">
                            {{ ucfirst($socio->tipo_usuario ?? 'N/A') }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $socio->fecha_afiliacion ? \Carbon\Carbon::parse($socio->fecha_afiliacion)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td>
                        @if($socio->user && $socio->user->roles->isNotEmpty())
                            @foreach($socio->user->roles as $role)
                                <span class="badge badge-secondary">{{ $role->name }}</span>@if(!$loop->last), @endif
                            @endforeach
                        @else
                            <span style="color: #999;">Sin roles</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>
            <strong>ASODAT - Asociación de Docentes y Trabajadores ESPE</strong><br>
            Documento generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
        </p>
    </div>
</body>
</html>
