<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Auditoría - {{ $auditoria->codigo }}</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .document-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .document-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a252f 100%);
            color: white;
            padding: 40px;
            position: relative;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header-left h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .header-left .document-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .document-code {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 24px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 1px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .document-body {
            padding: 40px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-bg);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::before {
            content: "▸";
            color: var(--secondary-color);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .info-card {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 24px;
            border-left: 4px solid var(--secondary-color);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .info-label {
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-completada {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(39, 174, 96, 0.2);
        }
        
        .status-proceso {
            background: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(243, 156, 18, 0.2);
        }
        
        .status-planificada {
            background: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
            border: 1px solid rgba(52, 152, 219, 0.2);
        }
        
        .status-revisada {
            background: rgba(155, 89, 182, 0.1);
            color: #9b59b6;
            border: 1px solid rgba(155, 89, 182, 0.2);
        }
        
        .hallazgos-section {
            margin-top: 40px;
        }
        
        .hallazgos-container {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 30px;
            border: 1px solid var(--border-color);
        }
        
        .hallazgos-content {
            white-space: pre-wrap;
            line-height: 1.8;
            color: var(--text-primary);
        }
        
        .timeline-section {
            margin-top: 40px;
        }
        
        .timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 20px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border-color);
            transform: translateY(-50%);
        }
        
        .timeline-item {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        
        .timeline-dot {
            width: 16px;
            height: 16px;
            background: var(--secondary-color);
            border-radius: 50%;
            margin: 0 auto 10px;
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--border-color);
        }
        
        .timeline-date {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .document-footer {
            background: var(--light-bg);
            padding: 24px 40px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: var(--text-secondary);
        }
        
        .footer-info {
            display: flex;
            gap: 20px;
        }
        
        .footer-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            
            .document-header,
            .document-body {
                padding: 24px;
            }
            
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .document-footer {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
            
            .footer-info {
                flex-direction: column;
                gap: 12px;
            }
            
            .timeline {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .timeline::before {
                left: 8px;
                right: auto;
                width: 2px;
                height: 100%;
                top: 0;
                transform: none;
            }
            
            .timeline-item {
                display: flex;
                align-items: center;
                gap: 16px;
                text-align: left;
            }
            
            .timeline-dot {
                margin: 0;
                flex-shrink: 0;
            }
        }
    </style>
</head>
<body>
    <div class="document-container">
        <header class="document-header">
            <div class="header-content">
                <div class="header-left">
                    <h1>INFORME DE AUDITORÍA</h1>
                    <div class="document-subtitle">Documento oficial - Sistema de Gestión de Calidad</div>
                </div>
                <div class="document-code">{{ $auditoria->codigo }}</div>
            </div>
        </header>
        
        <main class="document-body">
            <div class="info-grid">
                <div class="info-card">
                    <span class="info-label">Tipo de Auditoría</span>
                    <div class="info-value">{{ ucfirst($auditoria->tipo) }}</div>
                </div>
                
                <div class="info-card">
                    <span class="info-label">Auditor Responsable</span>
                    <div class="info-value">{{ $auditoria->auditor }}</div>
                </div>
                
                <div class="info-card">
                    <span class="info-label">Estado Actual</span>
                    <div class="info-value">
                        @if($auditoria->estado == 'completada')
                            <span class="status-badge status-completada">✓ Completada</span>
                        @elseif($auditoria->estado == 'proceso')
                            <span class="status-badge status-proceso">↻ En Proceso</span>
                        @elseif($auditoria->estado == 'planificada')
                            <span class="status-badge status-planificada">🗓 Planificada</span>
                        @elseif($auditoria->estado == 'revisada')
                            <span class="status-badge status-revisada">👁‍🗨 Revisada</span>
                        @else
                            <span class="status-badge status-planificada">{{ ucfirst($auditoria->estado) }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="info-card">
                    <span class="info-label">Ámbito de la Auditoría</span>
                    <div class="info-value">{{ $auditoria->alcance ?? 'No especificado' }}</div>
                </div>
            </div>
            
            <div class="section-title">Cronología</div>
            <div class="timeline-section">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">
                            {{ date('d/m/Y', strtotime($auditoria->fecha_inicio)) }}<br>
                            <small>Inicio</small>
                        </div>
                    </div>
                    
                    @if($auditoria->fecha_fin)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">
                            {{ date('d/m/Y', strtotime($auditoria->fecha_fin)) }}<br>
                            <small>Finalización</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($auditoria->hallazgos)
            <div class="section-title">Hallazgos y Observaciones</div>
            <div class="hallazgos-section">
                <div class="hallazgos-container">
                    <div class="hallazgos-content">{{ $auditoria->hallazgos }}</div>
                </div>
            </div>
            @endif
        </main>
        
        <footer class="document-footer">
            <div class="footer-info">
                <div class="footer-item">
                    <span>📄</span>
                    <span>Documento generado: {{ date('d/m/Y H:i', strtotime($auditoria->updated_at)) }}</span>
                </div>
                <div class="footer-item">
                    <span>🆔</span>
                    <span>ID de Registro: AUD-{{ str_pad($auditoria->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            <div class="footer-item">
                <span>🔒</span>
                <span>Documento confidencial - Uso interno</span>
            </div>
        </footer>
    </div>
</body>
</html>