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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeviceModal" >এড ডিভাইস</button>
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

<!-- Modal. -->

<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">নতুন ডিভাইস যোগ করুন</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @csrf
        <!-- Your form fields here -->
        <div class="mb-3">
            <label for="serial" class="form-label">সিরিয়াল নং</label>
            <input type="text" id="serial" class="form-control">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">ব্যক্তি বা কোম্পানীর নাম</label>
            <input type="text" id="name" class="form-control">
        </div>
        <div class="mb-3 position-relative">
            <label for="phone" class="form-label">ফোন নং</label>
            <input type="text" id="phone" class="form-control" > <!-- oninput="checkWhatsAppStatus()" -->
            <span id="whatsappTickAdd" class="whatsapp-icon">✔</span>
        </div>
        <div class="mb-3">
            <label for="validity" class="form-label">মেয়াদ</label>
            <select id="validity" class="form-select">
                <option value="1">১ বছর</option>
                <option value="2">২ বছর</option>
                <option value="3">৩ বছর</option>
                <option value="লাইফটাইম">লাইফটাইম</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="addDevice()">সেভ করুন</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
   async function addDevice() {
        const slNo = document.getElementById('serial').value;
        const companyName = document.getElementById('name').value;
        const phoneNo = document.getElementById('phone').value;
        const validity = document.getElementById('validity').value;

        if (slNo && companyName && phoneNo) {


            let data = {
                serial: slNo,
                name: companyName,
                phone: phoneNo,
                validity: validity
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('deviceSaveUpdate') }}",  // Laravel route
                type: 'POST',
                data: data,
                success: function(response) {
                    alert('Device saved successfully!');
                    $('#addDeviceModal').modal('hide');
                    // Optionally update table dynamically
                },
                error: function(xhr, status, error) {
                    alert('Failed to save device!');
                }
            });

            // ফর্ম খালি করা
            document.getElementById('serial').value = '';
            document.getElementById('name').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('validity').value = '1 বছর';

            closeModal('add');
        } else {
            alert('অনুগ্রহ করে সব ফিল্ড পূরণ করুন।');
        }
    }

</script>
@endsection
