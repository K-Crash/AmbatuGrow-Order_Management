<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Procurement Workspace' }}</title>
    <!-- Load Outfit Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Load Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg: #f3f6f4;
            --surface: rgba(255, 255, 255, 0.9);
            --surface-soft: #f9fbf9;
            --border: rgba(220, 228, 218, 0.8);
            --border-soft: rgba(232, 238, 230, 0.6);
            --text: #1a231b;
            --muted: #657467;
            --brand: #1e7d43;
            --brand-dark: #12502a;
            --brand-soft: rgba(30, 125, 67, 0.08);
            --shadow: 0 12px 34px rgba(25, 40, 30, 0.05);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f5f9f6 0%, #e2ecdf 100%);
            background-attachment: fixed;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; }

        .page-shell { min-height: 100vh; padding: 20px 28px; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .brand h1 {
            margin: 0 0 6px;
            font-size: 32px;
            line-height: 1.05;
            color: #0f1724;
            letter-spacing: -0.01em;
        }

        .brand p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .action-link,
        .btn,
        .chip-link {
            text-decoration: none;
            border-radius: 999px;
            font-weight: 700;
            transition: transform 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .action-link:hover,
        .btn:hover,
        .chip-link:hover { transform: translateY(-1px); }

        .content-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 520px;
            gap: 24px;
            align-items: start;
        }

        .dashboard-layout {
            display: grid;
            grid-template-columns: minmax(0, 4fr) minmax(320px, 1fr);
            gap: 24px;
            align-items: start;
        }

        .landing-grid {
            display: grid;
            gap: 24px;
        }

        .panel,
        .drawer,
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-header,
        .drawer-header {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .panel-header h2,
        .drawer-header h2 {
            margin: 0 0 6px;
            color: #0f1724;
            font-size: 28px;
            font-weight: 800;
        }

        .panel-header p,
        .drawer-header p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .card-section { padding: 24px; }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .stat-card {
            background: var(--surface-soft);
            border: 1px solid #e3e8e1;
            border-radius: 14px;
            padding: 16px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: .04em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 900;
            color: #0f1724;
            font-variant-numeric: tabular-nums;
        }

        .tabs { display: flex; gap: 8px; flex-wrap: wrap; }

        .tab {
            background: #f6f7f8;
            border: 1px solid #e3e8e1;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 13px;
            color: #4b5563;
            font-weight: 600;
        }

        .tab.active {
            background: var(--brand-soft);
            border-color: #d5e9d9;
            color: var(--brand);
        }

        .badge,
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-sent { background: #dbe6fd; color: #2354c9; }
        .badge-received { background: #d9f2e2; color: var(--brand); }
        .badge-overdue { background: #dc2626; color: #fff; }
        .badge-partial { background: #fdf1c7; color: #92680b; }
        .badge-draft { background: #eef0f2; color: #4b5563; }

        .table-wrap {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            overflow: hidden;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-wrap thead th {
            background: #f8faf8;
            padding: 10px 12px;
            text-align: left;
            color: var(--muted);
            font-size: 12px;
            border-bottom: 1px solid var(--border-soft);
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(4px);
        }

        .table-wrap tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #eef1ed;
            vertical-align: middle;
        }

        /* Right-align monetary column (Total) */
        .table-wrap tbody td:nth-child(5),
        .table-wrap thead th:nth-child(5) {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .table-wrap tbody tr:last-child td { border-bottom: none; }

        .action-row { display: flex; gap: 8px; flex-wrap: wrap; }

        .btn,
        .action-link,
        .chip-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d8dfd4;
            background: #fff;
            color: var(--brand-dark);
            padding: 10px 14px;
            font-size: 13px;
        }

        .btn-primary { background: var(--brand); color: #fff; border-color: var(--brand); padding: 12px 18px; box-shadow: 0 8px 20px rgba(30,125,67,0.18); }
        .btn-ghost { background: var(--brand-soft); color: var(--brand-dark); border-color: #d5e9d9; }
        .btn-soft { background: #f4f5f7; color: #334155; border-color: #e2e8f0; }

        .drawer { display: flex; flex-direction: column; }

        .drawer-body {
            padding: 24px;
            display: grid;
            gap: 18px;
        }

        .drawer-card {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            padding: 18px;
            background: #fff;
        }

        .drawer-title {
            font-size: 14px;
            font-weight: 800;
            color: #2f5d34;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .form-group { margin-bottom: 14px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #4b5563;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid #d6ddd3;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 14px;
            outline: none;
            background: #fff;
            font-family: inherit;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr .8fr 1fr;
            gap: 14px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            color: #555;
        }

        .summary-total {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 12px;
            font-weight: 700;
            font-size: 18px;
            color: var(--brand);
        }

        .drawer-footer {
            border-top: 1px solid #e4e8e2;
            padding: 20px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #fff;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 50;
        }

        .modal-backdrop.is-open {
            display: flex;
        }

        .modal {
            width: min(100%, 980px);
            max-height: calc(100vh - 48px);
            overflow: auto;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.28);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .modal .drawer-body {
            max-height: calc(100vh - 220px);
            overflow: auto;
        }

        body.modal-open .page-shell {
            pointer-events: none;
            user-select: none;
        }

        body.modal-open {
            overflow: hidden;
        }

        .section-anchor {
            scroll-margin-top: 24px;
        }

        .modal-close {
            cursor: pointer;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--brand-dark);
            margin-bottom: 10px;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 3px;
            border-radius: 999px;
            background: var(--brand);
        }

        .muted { color: var(--muted); }

        @media (max-width: 1180px) {
            .content-layout { grid-template-columns: 1fr; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 720px) {
            .page-shell { padding: 16px; }
            .stats { grid-template-columns: 1fr; }
            .panel-header,
            .drawer-header,
            .drawer-footer,
            .card-section,
            .drawer-body { padding-left: 18px; padding-right: 18px; }
            .form-grid-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div class="brand">
                <h1>{{ $workspaceTitle ?? 'Procurement Workspace' }}</h1>
                <p>{{ $workspaceSubtitle ?? 'A consistent frontend for purchase orders, creation, and notifications.' }}</p>
            </div>
            <div class="topbar-actions" style="display:flex; gap:12px; align-items:center; position:relative;">

                <button id="notif-btn" type="button" class="btn" aria-haspopup="dialog" aria-expanded="false" title="Notifications">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right:8px;">
                        <path d="M15 17H9" stroke="#165c32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 8.5C18 6.01472 15.9853 4 13.5 4C11.0147 4 9 6.01472 9 8.5V10C9 12.9853 7 14 7 14H20C20 14 18 12.9853 18 10V8.5Z" stroke="#165c32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.5 20C14.8807 20 16 18.8807 16 17.5" stroke="#165c32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span id="notif-count" class="badge badge-overdue" style="padding:4px 8px; font-size:12px;">0</span>
                </button>

                <!-- Notifications Popover (opened from topbar bell) -->
                <div id="notifications-popover" class="notification-popover" style="display:none; position:absolute; right:0; top:48px; width:340px; background:var(--surface); border:1px solid var(--border); border-radius:12px; box-shadow:0 12px 30px rgba(15,23,42,0.12); z-index:60; overflow:hidden; backdrop-filter: blur(12px);">
                    <div style="padding:12px 14px; border-bottom:1px solid var(--border-soft); background:var(--surface-soft);">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                            <div>
                                <div class="section-label" style="margin:0;">Notifications</div>
                                <div class="muted" style="font-size:13px;">Latest procurement alerts</div>
                            </div>
                        </div>
                    </div>
                    <div style="max-height:320px; overflow:auto; padding:12px; display:grid; gap:10px;">
                        @isset($purchaseOrders)
                            @php
                                $overdueCount = $purchaseOrders->filter(fn($po) => $po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast())->count();
                            @endphp
                            @if($overdueCount > 0)
                                <div class="mini-card notification-item" style="border-left: 4px solid #dc2626;">
                                    <div class="mini-title">Overdue Deliveries</div>
                                    @foreach($purchaseOrders->filter(fn($po) => $po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast())->take(3) as $po)
                                        <div style="font-weight:700; font-size:13px; color:#b91c1c; display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                                            <span>{{ $po->po_number }}</span>
                                            <span style="font-size:11px; font-weight:400; color:var(--muted)">Exp: {{ $po->expected_delivery->format('M d, Y') }}</span>
                                        </div>
                                        <div style="font-size:12px; margin-bottom:8px;">{{ $po->supplier->name }}</div>
                                    @endforeach
                                </div>
                            @endif
                        @endisset

                        @isset($invoices)
                            @if($invoices->count() > 0)
                                <div class="mini-card notification-item" style="border-left: 4px solid #2354c9;">
                                    <div class="mini-title">Matched Invoices</div>
                                    @foreach($invoices->take(2) as $inv)
                                        <div style="font-weight:700; font-size:13px; display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                                            <span>{{ $inv->invoice_number }}</span>
                                            <span style="font-size:11px; font-weight:400; color:var(--muted)">Matched to {{ $inv->purchaseOrder->po_number ?? '—' }}</span>
                                        </div>
                                        <div style="font-size:12px; margin-bottom:8px;">{{ $inv->supplier->name }} (₱{{ number_format($inv->amount, 2) }})</div>
                                    @endforeach
                                </div>
                            @endif
                        @endisset
                    </div>
                    <div style="padding:8px 12px; border-top:1px solid var(--border-soft); background:var(--surface); font-size:13px; color:var(--muted);">
                        <div style="text-align:right;">Viewed notifications are muted on the bell.</div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </div>
    <script>
        (function(){
            const btn = document.getElementById('notif-btn');
            const pop = document.getElementById('notifications-popover');
            const countEl = document.getElementById('notif-count');
            let unreadCount = 0;
            let viewed = false;

            function updateCount(){
                const items = pop ? pop.querySelectorAll('.notification-item') : [];
                // show unread count unless already viewed
                const display = viewed ? 0 : (unreadCount || items.length);
                if(countEl) {
                    countEl.textContent = display;
                    // when viewed, mute the badge appearance
                    if(viewed){
                        countEl.classList.remove('badge-overdue');
                        countEl.style.background = 'transparent';
                        countEl.style.color = 'var(--muted)';
                        countEl.style.border = '1px solid var(--border)';
                    }
                }
                // keep unreadCount synced to items length if not previously set
                if(!unreadCount) unreadCount = items.length;
            }

            function togglePopover(){
                if(!pop || !btn) return;
                const isOpen = pop.style.display === 'block';
                if(isOpen){
                    pop.style.display = 'none';
                    btn.setAttribute('aria-expanded','false');
                } else {
                    pop.style.display = 'block';
                    btn.setAttribute('aria-expanded','true');
                    // mark as viewed when opened: badge becomes muted but items remain
                    viewed = true;
                }
                updateCount();
            }

            function closePopover(){
                if(!pop || !btn) return;
                pop.style.display = 'none';
                btn.setAttribute('aria-expanded','false');
            }

            // click handlers
            document.addEventListener('click', function(e){
                const t = e.target;
                if(!t) return;

                // open/close when clicking the bell
                if(t.closest && t.closest('#notif-btn')){ e.preventDefault(); togglePopover(); return; }

                // open when clicking any element that should show notifications (e.g., table Review/Logs)
                if(t.closest && t.closest('.open-notif')){ e.preventDefault();
                    // open popover (do not toggle off)
                    if(pop.style.display !== 'block'){
                        pop.style.display = 'block';
                        btn.setAttribute('aria-expanded','true');
                        viewed = true;
                        updateCount();
                    }
                    return;
                }

                // close when clicking outside the popover and not on the bell
                if(pop && !t.closest('#notifications-popover') && !t.closest('#notif-btn')){
                    closePopover();
                }
            });

            document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closePopover(); });

            // init
            updateCount();
        })();
    </script>
    @yield('scripts')

    <!-- Toast Notification Container -->
    <div id="toast-container" style="position: fixed; top: 24px; right: 24px; z-index: 1000; display: grid; gap: 10px; pointer-events: none;"></div>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.style = `
                min-width: 300px;
                background: #ffffff;
                border: 1px solid rgba(220, 228, 218, 0.9);
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                padding: 14px 18px;
                display: flex;
                align-items: center;
                gap: 12px;
                pointer-events: auto;
                transform: translateX(120%);
                transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s;
                border-left: 4px solid \${type === 'success' ? '#1e7d43' : '#dc2626'};
            `;

            const icon = type === 'success' 
                ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="#1e7d43" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`
                : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="2.5"/><path d="M12 8V12M12 16H12.01" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

            toast.innerHTML = `
                <div style="flex-shrink:0; display:flex;">\${icon}</div>
                <div style="flex-grow:1; font-size:13px; font-weight:600; color:#1a231b; font-family:'Outfit',sans-serif;">\${message}</div>
                <button onclick="this.parentElement.remove()" style="background:none; border:none; cursor:pointer; font-size:16px; color:#a0aec0; padding:0;">&times;</button>
            `;

            container.appendChild(toast);
            
            // Trigger slide-in
            setTimeout(() => { toast.style.transform = 'translateX(0)'; }, 10);

            // Auto-dismiss after 4 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(120%)';
                toast.style.opacity = '0';
                setTimeout(() => { toast.remove(); }, 300);
            }, 4000);
        }

        @if(session('status'))
            document.addEventListener('DOMContentLoaded', () => { showToast("{{ session('status') }}", 'success'); });
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', () => { showToast("{{ session('error') }}", 'danger'); });
        @endif
    </script>
</body>
</html>
