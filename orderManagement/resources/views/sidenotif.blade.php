@extends('layouts.procurement', [
    'pageTitle' => 'Side Notifications',
    'workspaceTitle' => 'Side Notifications',
    'workspaceSubtitle' => 'A consistent alert sidebar with the same procurement palette and spacing.',
    'activePage' => 'notif',
])

@section('content')
    <section class="drawer" style="max-width: 420px; margin-left:auto;">
        <div class="drawer-header">
            <div>
                <h2>Procurement Sidebar</h2>
                <p>Linked to the same PO workflow as the rest of the frontend.</p>
            </div>
            <a class="action-link" href="{{ route('procurement.purchase') }}">Purchase Orders</a>
        </div>

        <div class="drawer-body">
            <div class="drawer-card">
                <div class="drawer-title">Approvals Inbox</div>
                <div class="chip" style="background:#fef3d6; color:#b8860b;">0 Awaiting</div>
                <p class="muted" style="margin: 14px 0 0;">Approval queue is empty.</p>
            </div>

            <div class="drawer-card">
                <div class="drawer-title">PO Pipeline</div>
                <div class="stats" style="grid-template-columns: repeat(2, 1fr); margin-bottom: 14px;">
                    <div class="stat-card">
                        <div class="stat-label">Drafts</div>
                        <div class="stat-value">1</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">In Flight</div>
                        <div class="stat-value">2</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Procurement Value</div>
                    <div class="stat-value">₱227,920</div>
                </div>
            </div>

            <div class="drawer-card">
                <div class="drawer-title">Delivery Alerts</div>
                <div class="badge badge-overdue" style="display:inline-flex; margin-bottom:10px;">PO-2026-001 Overdue</div>
                <p style="margin:0; font-weight:700;">AgriSource PH Inc.</p>
                <p class="muted" style="margin:6px 0 0;">Immediate follow-up required.</p>
            </div>

            <div class="drawer-card">
                <div class="drawer-title">Invoice Matching</div>
                <div class="badge badge-partial" style="display:inline-flex; margin-bottom:10px;">Discrepancy</div>
                <p style="margin:0; font-weight:700;">INV-SUP-2026-003</p>
                <p class="muted" style="margin:6px 0 0;">TechVend Solutions - ₱67,200</p>
            </div>
        </div>

        <div class="drawer-footer">
            <a class="btn btn-ghost" href="{{ route('procurement.purchase') }}">Purchase Orders</a>
            <a class="btn btn-primary" href="{{ route('procurement.create') }}">Create PO</a>
        </div>
    </section>
@endsection
