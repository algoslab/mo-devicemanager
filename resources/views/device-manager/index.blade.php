@extends('layouts.master')

@section('styles')
<style>
    
</style>
@endsection

@section('content')
<!-- Dashboard Page -->
<div class="container mt-5" id="dashboard-page">
    <div class=" mb-3">
        <h1 class=" pb-2 text-center dashboard-title">ডিভাইস ম্যানেজমেন্ট ড্যাশবোর্ড</h1>
        <button class="btn btn-danger logout-btn" onclick="logout()">লগআউট</button>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" onclick="openModal('add')">এড ডিভাইস</button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>সিরিয়াল নং</th>
                <th>ব্যক্তি বা কোম্পানীর নাম</th>
                <th>ফোন নং</th>
                <th>মেয়াদ</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody id="deviceTableBody">
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    function addDevice() {
        alert('Add device logic here!');
    }
</script>
@endsection
