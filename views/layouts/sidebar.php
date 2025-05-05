<div class="sidebar bg-dark text-white p-3" id="sidebar">
    <button class="btn btn-light mb-4 d-md-none" id="sidebarToggle">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h4 class="mb-4">Task Management</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white <?php echo $activePage == 'todos' ? 'active' : ''; ?>" href="/todos">Tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="/users">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="/tags">Tags</a>
        </li>
    </ul>
</div>