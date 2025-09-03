<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডিভাইস ম্যানেজমেন্ট</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
        }
        .whatsapp-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #25D366;
            font-size: 24px;
            display: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<!-- Login Page -->
<div id="login-page" class="card p-4 shadow" style="width: 350px;">
    <h1 class="text-center mb-4">লগইন</h1>
    <input type="text" id="username" class="form-control mb-3" placeholder="ইউজারনেম">
    <input type="password" id="password" class="form-control mb-3" placeholder="পাসওয়ার্ড">
    <button class="btn btn-primary w-100" onclick="login()">লগইন</button>
</div>

<!-- Dashboard Page -->
<div class="container mt-5 d-none" id="dashboard-page">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="border-bottom pb-2">ডিভাইস ম্যানেজমেন্ট ড্যাশবোর্ড</h1>
        <button class="btn btn-danger" onclick="logout()">লগআউট</button>
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

<!-- Add Device Modal -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="addDeviceModalLabel">নতুন ডিভাইস যোগ করুন</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body position-relative">
        <div class="mb-3 position-relative">
            <label for="slNo" class="form-label">সিরিয়াল নং</label>
            <input type="text" id="slNo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="companyName" class="form-label">ব্যক্তি বা কোম্পানীর নাম</label>
            <input type="text" id="companyName" class="form-control">
        </div>
        <div class="mb-3 position-relative">
            <label for="phoneNo" class="form-label">ফোন নং</label>
            <input type="text" id="phoneNo" class="form-control" oninput="checkWhatsAppStatus()">
            <span id="whatsappTickAdd" class="whatsapp-icon">✔</span>
        </div>
        <div class="mb-3">
            <label for="validity" class="form-label">মেয়াদ</label>
            <select id="validity" class="form-select">
                <option value="1 বছর">১ বছর</option>
                <option value="2 বছর">২ বছর</option>
                <option value="3 বছর">৩ বছর</option>
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

<!-- Renew Device Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="renewModalLabel">মেয়াদ রিনিউ করুন</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="renewSlNo" class="form-label">সিরিয়াল নং</label>
            <input type="text" id="renewSlNo" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="renewValidity" class="form-label">নতুন মেয়াদ</label>
            <select id="renewValidity" class="form-select">
                <option value="1 বছর">১ বছর</option>
                <option value="2 বছর">২ বছর</option>
                <option value="3 বছর">৩ বছর</option>
                <option value="লাইফটাইম">লাইফটাইম</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="renewDevice()">রিনিউ করুন</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function login() {
        document.getElementById('login-page').classList.add('d-none');
        document.getElementById('dashboard-page').classList.remove('d-none');
    }
    function logout() {
        document.getElementById('login-page').classList.remove('d-none');
        document.getElementById('dashboard-page').classList.add('d-none');
    }
    function openModal(modal) {
        const m = new bootstrap.Modal(document.getElementById(modal + 'DeviceModal'));
        m.show();
    }
    function closeModal(modal) {
        const m = bootstrap.Modal.getInstance(document.getElementById(modal + 'DeviceModal'));
        m.hide();
    }
    function addDevice() {
        // Add device logic here
    }
    function renewDevice() {
        // Renew device logic here
    }
    function checkWhatsAppStatus() {
        // WhatsApp tick logic
    }
</script>

</body>
</html>
