<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text"> MG Property</div>
    </a>

    <hr class="sidebar-divider my-0" />

    <li class="nav-item <?= (current_url() == base_url('dashboard') ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider" />

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <div class="sidebar-heading">Master Data</div>
    <li class="nav-item <?= (current_url() == base_url('calendar') ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('calendar') ?>">
            <i class="fas fa-calendar"></i>
            <span>Calendar</span>
        </a>
    </li>
    <li class="nav-item <?= (current_url() == base_url('CashFlow') ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('CashFlow') ?>">
            <i class="fas fa-dollar-sign"></i>
            <span>Cash Flow</span>
        </a>
    </li>

    <li class="nav-item <?= (current_url() == base_url('unit') ? 'active' : '') ?>">
        <a class="nav-link" href="<?= base_url('unit') ?>">
            <i class="fas fa-building"></i>
            <span>Unit</span>
        </a>
    </li>

    <hr class="sidebar-divider" />

    <?php if ($auth['level_id'] != 3): ?>
        <div class="sidebar-heading">Report</div>
        <li class="nav-item <?= (current_url() == base_url('report') ? 'active' : '') ?>">
            <a class="nav-link" href="<?= base_url('report') ?>">
                <i class="far fa-clipboard"></i>
                <span>Reporting</span>
            </a>
        </li>

        <hr class="sidebar-divider" />

        <div class="sidebar-heading">Settings</div>
        <li class="nav-item <?= (current_url() == base_url('account') ? 'active' : '') ?>">
            <a class="nav-link" href="<?= base_url('account') ?>">
                <i class="fas fa-key"></i>
                <span>Account</span>
            </a>
        </li>
    <?php endif; ?>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>