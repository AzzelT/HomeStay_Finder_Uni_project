@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Site Settings</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <h5 class="mb-3">Maintenance Mode</h5>
                    <p class="text-muted mb-4">
                        When enabled, regular visitors will see a "Website Under Maintenance" page.
                        Admins will still be able to access the site.
                    </p>

                    <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                        @csrf

                        {{-- THIS HIDDEN INPUT FIXES THE ERROR --}}
                        <input type="hidden" name="is_maintenance" value="0">

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="maintenanceToggle" name="is_maintenance" value="1"
                                   {{ $isMaintenance ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="maintenanceToggle">
                                {{ $isMaintenance ? 'Maintenance Mode is ON' : 'Maintenance Mode is OFF' }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
