@extends('layouts.procurement', [
    'pageTitle' => 'Procurement Landing',
    'workspaceTitle' => 'Procurement Landing',
    'workspaceSubtitle' => 'Purchase on the left, alerts on the right, and Create PO in a modal.',
])

@section('content')
    <style>
        .dashboard-layout {
            display: grid;
            grid-template-columns: minmax(0, 4fr) minmax(300px, 1fr);
            gap: 24px;
            align-items: start;
        }

        .page-section {
            background: #fff;
            border: 1px solid #dfe5dc;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .page-section-header {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 22px 24px;
            border-bottom: 1px solid #e8ece7;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #165c32;
            margin-bottom: 8px;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 3px;
            border-radius: 999px;
            background: #1e7d43;
        }

        .page-section-header h2 {
            margin: 0 0 6px;
            font-size: 26px;
            color: #0f1724;
            font-weight: 800;
        }

        .page-section-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .section-body {
            padding: 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .stat-card {
            background: #f8faf8;
            border: 1px solid #e3e8e1;
            border-radius: 14px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 76px;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            letter-spacing: .04em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #14213d;
        }

        .tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .tab {
            border: 1px solid #e3e8e1;
            background: #f6f7f8;
            color: #4b5563;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .tab.active {
            background: #eef7f0;
            color: #1e7d43;
            border-color: #d5e9d9;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            padding: 0 6px;
            margin-left: 6px;
            border-radius: 999px;
            background: rgba(255,255,255,.75);
            font-size: 11px;
        }

        .table-wrap {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            max-height: 420px;
        }

        .table-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-wrap tbody { display: block; max-height: 360px; overflow: auto; }
        .table-wrap thead, .table-wrap tbody tr { display: table; width: 100%; table-layout: fixed; }

        .table-wrap thead th {
            text-align: left;
            padding: 14px 16px;
            color: #6b7280;
            font-size: 12px;
            background: #f8faf8;
            border-bottom: 1px solid #e8ece7;
            white-space: nowrap;
        }

        .table-wrap tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #eef1ed;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-wrap tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-sent { background: #dbe6fd; color: #2354c9; }
        .badge-received { background: #d9f2e2; color: #1e7d43; }
        .badge-overdue { background: #ef4444; color: #fff; }
        .badge-partial { background: #fdf1c7; color: #92680b; }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn,
        .action-link,
        .chip-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid #d8dfd4;
            background: #fff;
            color: #165c32;
            font-weight: 700;
            text-decoration: none;
            padding: 10px 14px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-primary {
            background: #1e7d43;
            color: #fff;
            border-color: #1e7d43;
            padding: 12px 18px;
            box-shadow: 0 8px 20px rgba(30,125,67,0.18);
            font-size: 14px;
        }

        .btn-soft {
            background: #f4f5f7;
            color: #334155;
            border-color: #e2e8f0;
        }

        .btn-ghost {
            background: #eef7f0;
            color: #165c32;
            border-color: #d5e9d9;
        }

        .alerts-card {
            display: grid;
            gap: 16px;
        }

        .mini-card {
            border: 1px solid #e4e8e2;
            border-radius: 14px;
            padding: 18px;
            background: #fff;
        }

        .mini-card:target {
            outline: 2px solid #1e7d43;
            outline-offset: 2px;
        }

        .mini-title {
            font-size: 14px;
            font-weight: 800;
            color: #2f5d34;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .muted {
            color: #6b7280;
        }

        .log-list {
            display: grid;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .log-item {
            padding: 12px 14px;
            border: 1px solid #e4e8e2;
            border-radius: 12px;
            background: #fdfefe;
        }

        .log-item strong {
            display: block;
            margin-bottom: 4px;
            color: #14213d;
        }

        .overlay-card {
            width: min(980px, calc(100vw - 48px));
            max-height: calc(100vh - 48px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
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

        .modal-backdrop:target {
            display: flex;
        }

        .modal {
            width: min(980px, calc(100vw - 48px));
            max-height: calc(100vh - 48px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .modal .drawer-header {
            flex-shrink: 0;
        }

        .modal .drawer-body {
            flex: 1;
            overflow: auto;
            min-height: 0;
        }

        .modal .drawer-footer {
            flex-shrink: 0;
        }

        @media (max-width: 1180px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .table-wrap tbody { max-height: 320px; }
        }

        @media (max-width: 720px) {
            .section-body,
            .page-section-header {
                padding-left: 18px;
                padding-right: 18px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-layout" id="dashboard-root">
        <section id="purchase" class="page-section">
            <div class="page-section-header">
                <div>
                    <div class="section-label">Procurement Overview</div>
                    <h2>Purchase activity and order status</h2>
                    <p>Current purchase orders with dynamic stats and functional workflows.</p>
                </div>
                <div class="header-actions">
                    <a class="btn btn-primary" href="#createpo-modal" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        CREATE PO
                    </a>
                </div>
            </div>

            <div class="section-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">TOTAL POS</div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">PENDING / DRAFT</div>
                        <div class="stat-value">{{ $stats['draft'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">ACTIVE / SENT</div>
                        <div class="stat-value">{{ $stats['sent'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">OVERDUE</div>
                        <div class="stat-value" style="color: #dc2626;">{{ $stats['overdue'] }}</div>
                    </div>
                </div>

                <!-- Spend & Status Analytics Charts -->
                <div class="analytics-section" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin: 24px 0;">
                    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 18px; padding: 22px; box-shadow: var(--shadow);">
                        <div class="mini-title" style="margin-bottom:16px; font-weight:800; font-size:13px; color:var(--brand-dark);">Supplier Spend Distribution (₱)</div>
                        <div style="height: 220px; position: relative;">
                            <canvas id="spendChart"></canvas>
                        </div>
                    </div>
                    <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 18px; padding: 22px; box-shadow: var(--shadow); display: flex; flex-direction: column;">
                        <div class="mini-title" style="margin-bottom:16px; font-weight:800; font-size:13px; color:var(--brand-dark);">Order Status Allocation</div>
                        <div style="height: 220px; position: relative; display: flex; justify-content: center; align-items: center; flex:1;">
                            <canvas id="statusChart" style="max-height: 180px; max-width: 180px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="tabs" role="tablist" aria-label="PO Filters">
                    <button type="button" class="tab active" data-filter="all">All <span class="chip">{{ $purchaseOrders->count() }}</span></button>
                    <button type="button" class="tab" data-filter="draft">Draft <span class="chip">{{ $purchaseOrders->where('status','draft')->count() }}</span></button>
                    <button type="button" class="tab" data-filter="sent">Sent to Supplier <span class="chip">{{ $purchaseOrders->where('status','sent')->count() }}</span></button>
                    <button type="button" class="tab" data-filter="received">Fully Received <span class="chip">{{ $purchaseOrders->where('status','received')->count() }}</span></button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>PO ID</th>
                                <th>Supplier</th>
                                <th>Date Issued</th>
                                <th>Expected Delivery</th>
                                <th>Total (₱)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody data-po-table>
                            @forelse($purchaseOrders as $po)
                                @php
                                    $isOverdue = $po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast();
                                @endphp
                                <tr class="po-row" style="transition: all 0.2s ease;">
                                    <td style="font-weight: 700;">{{ $po->po_number }}</td>
                                    <td>{{ $po->supplier->name ?? '—' }}</td>
                                    <td>{{ optional($po->issued_at)->format('M d, Y') ?? optional($po->created_at)->format('M d, Y') }}</td>
                                    <td style="{{ $isOverdue ? 'color: #dc2626; font-weight: 700;' : '' }}">
                                        {{ optional($po->expected_delivery)->format('M d, Y') ?? '—' }}
                                        @if($isOverdue)
                                            <span style="font-size: 10px; display: block; text-transform: uppercase; letter-spacing: 0.05em;">⚠️ Overdue</span>
                                        @endif
                                    </td>
                                    <td style="font-weight: 600;">{{ number_format($po->total, 2) }}</td>
                                    <td>
                                        @if($po->status === 'sent')
                                            <span class="badge badge-sent">Sent to Supplier</span>
                                        @elseif($po->status === 'received')
                                            <span class="badge badge-received">Fully Received</span>
                                        @elseif($po->status === 'draft')
                                            <span class="badge badge-draft">Draft</span>
                                        @else
                                            <span class="badge">{{ ucfirst($po->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-row">
                                            @if($po->status === 'draft')
                                                <a class="chip-link btn-soft" href="{{ route('procurement.create') }}?edit={{ $po->id }}">Edit</a>
                                                <form method="POST" action="{{ route('purchase_orders.send', $po) }}" style="display:inline">
                                                    @csrf
                                                    <button type="submit" class="chip-link btn-primary" style="background:var(--brand); color:#fff; border-color:var(--brand);">Send</button>
                                                </form>
                                            @elseif($po->status === 'sent')
                                                <form method="POST" action="{{ route('purchase_orders.status', $po) }}" style="display:inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="received" />
                                                    <button type="submit" class="chip-link btn-ghost">Receive</button>
                                                </form>
                                            @else
                                                <span class="muted" style="font-size:12px;">Completed</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--muted);">
                                        No purchase orders found. Create one to get started!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <aside id="sidenotif" class="page-section">
            <div class="page-section-header">
                <div>
                    <div class="section-label">Workflow</div>
                    <h2>Review &amp; Logs</h2>
                    <p>Access approvals, matched invoices, and activity logs.</p>
                </div>
            </div>

            <div class="section-body">
                <div class="sidebar-nav" style="display:grid; gap:16px;">
                    <div class="tier-primary" style="display:flex; gap:6px; flex-wrap:wrap;">
                        <button type="button" class="tab side-tab active" data-section="notifications" style="padding: 8px 12px; font-size:12px;">Alerts</button>
                        <button type="button" class="tab side-tab" data-section="match-invoice" style="padding: 8px 12px; font-size:12px;">Match Invoice</button>
                        <button type="button" class="tab side-tab" data-section="logs" style="padding: 8px 12px; font-size:12px;">Activity</button>
                    </div>

                    <div class="tier-secondary">
                        <!-- Notifications/Alerts Section -->
                        <div class="mini-card side-section" data-section="notifications">
                            <div class="mini-title">Delivery Alerts</div>
                            <div class="log-list">
                                @php $alertCount = 0; @endphp
                                @foreach($purchaseOrders as $po)
                                    @if($po->status !== 'received' && $po->expected_delivery && $po->expected_delivery->isPast())
                                        @php $alertCount++; @endphp
                                        <div class="log-item" style="border-left: 3px solid #dc2626; background: #fffdfd;">
                                            <strong style="color: #b91c1c;">⚠️ {{ $po->po_number }} Overdue</strong>
                                            <div class="muted" style="font-size:12px;">{{ $po->supplier->name ?? '—' }}</div>
                                            <div style="font-size:11px; margin-top:4px;">Expected: {{ $po->expected_delivery->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                @endforeach
                                @if($alertCount === 0)
                                    <div class="muted" style="text-align: center; padding: 20px; font-size:13px;">No pending delivery alerts.</div>
                                @endif
                            </div>
                        </div>

                        <!-- Match Invoice Form Section -->
                        <div class="mini-card side-section" data-section="match-invoice" style="display:none">
                            <div class="mini-title">Match Invoice to PO</div>
                            <form method="POST" action="{{ route('purchase_orders.match_invoice') }}">
                                @csrf
                                <div class="form-group">
                                    <label style="font-size:12px; font-weight:700;">Select Purchase Order *</label>
                                    <select name="po_number" required style="width:100%; border:1px solid #d6ddd3; border-radius:10px; padding:8px 10px; font-size:13px;">
                                        <option value="">Choose Active PO...</option>
                                        @foreach($purchaseOrders as $po)
                                            @if($po->status === 'sent')
                                                <option value="{{ $po->po_number }}">{{ $po->po_number }} — {{ $po->supplier->name }} (₱{{ number_format($po->total, 2) }})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:12px; font-weight:700;">Invoice Reference *</label>
                                    <input type="text" name="invoice_number" required placeholder="e.g. INV-SUP-001" style="width:100%; border:1px solid #d6ddd3; border-radius:10px; padding:8px 10px; font-size:13px;" />
                                </div>
                                <div class="form-group">
                                    <label style="font-size:12px; font-weight:700;">Invoice Amount (₱) *</label>
                                    <input type="number" step="0.01" name="amount" required placeholder="0.00" style="width:100%; border:1px solid #d6ddd3; border-radius:10px; padding:8px 10px; font-size:13px;" />
                                </div>
                                <button type="submit" class="btn btn-primary" style="width:100%; padding:10px; font-size:13px; font-weight:700;">
                                    Match Invoice
                                </button>
                            </form>
                        </div>

                        <!-- Logs Section -->
                        <div class="mini-card side-section" data-section="logs" style="display:none">
                            <div class="mini-title">Recent Activities</div>
                            <div class="log-list">
                                @foreach($purchaseOrders->where('status', '!=', 'draft')->take(3) as $po)
                                    <div class="log-item">
                                        <strong>PO Transmitted</strong>
                                        <div class="muted" style="font-size:12px;">{{ $po->po_number }} issued to {{ $po->supplier->name }}</div>
                                        <div style="font-size:10px; margin-top:4px; color:var(--muted);">{{ $po->updated_at->diffForHumans() }}</div>
                                    </div>
                                @endforeach
                                @foreach($invoices->take(2) as $inv)
                                    <div class="log-item" style="border-left: 3px solid #2354c9;">
                                        <strong>Invoice Matched</strong>
                                        <div class="muted" style="font-size:12px;">{{ $inv->invoice_number }} to {{ $inv->purchaseOrder->po_number ?? '—' }}</div>
                                        <div style="font-size:10px; margin-top:4px; color:var(--muted);">{{ $inv->received_at->diffForHumans() }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Create PO Modal Backed by a Fully Functional Form -->
    <div class="modal-backdrop" id="createpo-modal" aria-hidden="true">
        <div class="modal overlay-card">
            <form method="POST" action="{{ route('purchase_orders.store') }}" id="modal-create-po-form">
                @csrf
                <div class="drawer-header" style="backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-soft); position: sticky; top:0; z-index:10; background:rgba(255,255,255,0.9);">
                    <div>
                        <div class="section-label">PO Entry</div>
                        <h2>New purchase order</h2>
                        <p>Draft a new purchase order directly from the overview dashboard.</p>
                    </div>
                    <a class="btn btn-soft" href="#purchase">Close</a>
                </div>

                <div class="drawer-body" style="padding: 24px; display: grid; gap: 20px;">
                    <div class="drawer-card">
                        <div class="drawer-title">Purchase Summary</div>
                        <div class="summary-row"><span>Subtotal</span><strong id="modal_subtotal_display">₱0.00</strong></div>
                        <div class="summary-row"><span>VAT (12%)</span><strong id="modal_vat_display">₱0.00</strong></div>
                        <div class="summary-row summary-total"><span>Total</span><strong id="modal_total_display">₱0.00</strong></div>
                    </div>

                    <div class="drawer-card">
                        <div class="drawer-title">Supplier Information</div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier_id" required style="width:100%; border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Expected Delivery</label>
                            <input type="date" name="expected_delivery" style="width:100%; border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                           <label>Payment Terms</label>
                           <select name="payment_terms" style="width:100%; border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;">
                               <option>Net 30</option>
                               <option>Net 15</option>
                               <option>COD</option>
                           </select>
                       </div>
                    </div>

                    <div class="drawer-card">
                        <div class="drawer-title">Line Items</div>
                        <div id="modal-items-list">
                            <div class="item-row" data-index="0" style="display:grid; grid-template-columns: 1fr 1.2fr 0.8fr 1fr 40px; gap:8px; align-items:center; margin-bottom:8px;">
                                <input type="text" name="items[0][sku]" placeholder="SKU" style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                                <input type="text" name="items[0][name]" placeholder="Item name" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                                <input type="number" name="items[0][quantity]" value="1" min="1" class="item-qty" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                                <input type="number" step="0.01" name="items[0][unit_price]" value="0.00" class="item-price" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                                <button type="button" class="btn btn-soft remove-item" style="height: 44px; padding:0; border-radius: 10px;">−</button>
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <button type="button" id="modal-add-item" class="btn btn-ghost" style="font-weight:700;">+ Add line item</button>
                        </div>
                    </div>

                    <div class="drawer-card">
                        <div class="drawer-title">Notes / Instructions</div>
                        <div class="form-group" style="margin-bottom:0;">
                            <textarea name="notes" rows="4" placeholder="Delivery instructions or warehouse directions..." style="width:100%; border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px; font-family: inherit; resize: vertical;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="drawer-footer" style="position: sticky; bottom:0; z-index:10; border-top: 1px solid var(--border-soft); background:#fff;">
                    <a class="btn btn-soft" href="#purchase">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="font-weight: 700;">Save Draft</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // --- POPULAR SIDEBAR SECTIONS SWITCHER ---
            const tabs = document.querySelectorAll('#sidenotif .side-tab');
            const sections = document.querySelectorAll('#sidenotif .side-section');
            if(tabs.length && sections.length) {
                function showSection(name){
                    sections.forEach(s=> s.style.display = (s.dataset.section === name) ? '' : 'none');
                    tabs.forEach(t=> t.classList.toggle('active', t.dataset.section === name));
                }
                tabs.forEach(t=> t.addEventListener('click', ()=> showSection(t.dataset.section)));
                const active = Array.from(tabs).find(t=> t.classList.contains('active')) || tabs[0];
                if(active) showSection(active.dataset.section);
            }

            // --- CLIENT-SIDE TABLE STATUS FILTERING ---
            const tabButtons = document.querySelectorAll('.tabs .tab');
            const tbody = document.querySelector('[data-po-table]');
            if(tbody && tabButtons.length) {
                const rows = Array.from(tbody.querySelectorAll('tr.po-row'));

                function inferStatusesFromRow(row){
                    const badge = row.querySelector('.badge');
                    if(!badge) return [];
                    const txt = badge.textContent.trim().toLowerCase();
                    const s = [];
                    if(txt.includes('draft')) s.push('draft');
                    if(txt.includes('sent')) s.push('sent');
                    if(txt.includes('received')) s.push('received');
                    return s;
                }

                rows.forEach(r => {
                    r.dataset.status = inferStatusesFromRow(r).join(',');
                });

                function applyFilter(filter){
                    rows.forEach(r => {
                        if(filter === 'all'){
                            r.style.display = '';
                        } else {
                            const st = (r.dataset.status||'');
                            r.style.display = st.split(',').includes(filter) ? '' : 'none';
                        }
                    });
                }

                function updateChips(){
                    tabButtons.forEach(btn => {
                        const filter = btn.dataset.filter || 'all';
                        let count = 0;
                        if(filter === 'all') count = rows.length;
                        else count = rows.filter(r => (r.dataset.status||'').split(',').includes(filter)).length;
                        const chip = btn.querySelector('.chip');
                        if(chip) chip.textContent = count;
                    });
                }

                tabButtons.forEach(btn => btn.addEventListener('click', function(e){
                    e.preventDefault();
                    tabButtons.forEach(b=>b.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter || 'all';
                    applyFilter(filter);
                }));

                updateChips();
                const activeTab = document.querySelector('.tabs .tab.active');
                if(activeTab) applyFilter(activeTab.dataset.filter || 'all');
            }

            // --- DYNAMIC ITEM ROWS & RECALC FOR MODAL PO FORM ---
            const addBtn = document.getElementById('modal-add-item');
            const itemsList = document.getElementById('modal-items-list');
            let index = 1;

            if (addBtn && itemsList) {
                function recalc(){
                    const rows = itemsList.querySelectorAll('.item-row');
                    let subtotal = 0;
                    rows.forEach(r=>{
                        const qty = parseFloat(r.querySelector('.item-qty').value) || 0;
                        const price = parseFloat(r.querySelector('.item-price').value) || 0;
                        subtotal += qty * price;
                    });
                    const vat = subtotal * 0.12;
                    const total = subtotal + vat;
                    
                    document.getElementById('modal_subtotal_display').textContent = '₱' + subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('modal_vat_display').textContent = '₱' + vat.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('modal_total_display').textContent = '₱' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                addBtn.addEventListener('click', function(){
                    const row = document.createElement('div');
                    row.className = 'item-row';
                    row.dataset.index = index;
                    row.style = 'display:grid; grid-template-columns: 1fr 1.2fr 0.8fr 1fr 40px; gap:8px; align-items:center; margin-bottom:8px;';
                    row.innerHTML = `
                        <input type="text" name="items[${index}][sku]" placeholder="SKU" style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                        <input type="text" name="items[${index}][name]" placeholder="Item name" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                        <input type="number" name="items[${index}][quantity]" value="1" min="1" class="item-qty" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                        <input type="number" step="0.01" name="items[${index}][unit_price]" value="0.00" class="item-price" required style="border: 1px solid #d6ddd3; border-radius: 10px; padding: 11px 12px; font-size: 14px;" />
                        <button type="button" class="btn btn-soft remove-item" style="height: 44px; padding:0; border-radius:10px;">−</button>
                    `;
                    itemsList.appendChild(row);
                    index++;
                    row.querySelectorAll('.item-qty, .item-price').forEach(el=>el.addEventListener('input', recalc));
                    row.querySelector('.remove-item').addEventListener('click', function(){ row.remove(); recalc(); });
                    recalc();
                });

                // Attach handlers for initial row
                itemsList.querySelectorAll('.item-qty, .item-price').forEach(el=>el.addEventListener('input', recalc));
                itemsList.querySelectorAll('.remove-item').forEach(btn=>btn.addEventListener('click', function(e){ 
                    const row = e.target.closest('.item-row');
                    if (itemsList.querySelectorAll('.item-row').length > 1) {
                        row.remove(); 
                        recalc(); 
                    } else {
                        alert('A Purchase Order must have at least one line item.');
                    }
                }));
                
                recalc();
            }

            // --- ANALYTICS CHARTS INITIALIZATION ---
            const spendData = @json($spendData);
            const spendLabels = spendData.map(d => d.supplier);
            const spendTotals = spendData.map(d => d.total);

            // Spend Chart (Bar Chart)
            const ctxSpend = document.getElementById('spendChart').getContext('2d');
            new Chart(ctxSpend, {
                type: 'bar',
                data: {
                    labels: spendLabels,
                    datasets: [{
                        label: 'Total Spend (₱)',
                        data: spendTotals,
                        backgroundColor: 'rgba(30, 125, 67, 0.75)',
                        borderColor: '#1e7d43',
                        borderWidth: 1.5,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(232, 238, 230, 0.4)' },
                            ticks: { font: { family: 'Outfit', size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Outfit', size: 11 } }
                        }
                    }
                }
            });

            // Status Chart (Doughnut Chart)
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Draft', 'Sent', 'Received'],
                    datasets: [{
                        data: [
                            {{ $purchaseOrders->where('status', 'draft')->count() }},
                            {{ $purchaseOrders->where('status', 'sent')->count() }},
                            {{ $purchaseOrders->where('status', 'received')->count() }}
                        ],
                        backgroundColor: [
                            'rgba(107, 114, 128, 0.75)', // Draft
                            'rgba(35, 84, 201, 0.75)',  // Sent
                            'rgba(30, 125, 67, 0.75)'   // Received
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { font: { family: 'Outfit', size: 12 } }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
@endsection
