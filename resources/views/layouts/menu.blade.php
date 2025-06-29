<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class="fas fa-building"></i><span>Dashboard</span>
    </a>
</li>

<li class="{{ Request::is('transactions*') ? 'active' : '' }}">
    <a href="{{ route('admin.transactions.index') }}"><i class="fas fa-exchange-alt"></i><span>Transactions</span></a>
</li>

<li class="{{ Request::is('savingGoals*') ? 'active' : '' }}">
    <a href="{{ route('admin.savingGoals.index') }}"><i class="fas fa-bullseye"></i><span>SavingGoals</span></a>
</li>

<li class="{{ Request::is('notifications*') ? 'active' : '' }}">
    <a href="{{ route('admin.notifications.index') }}"><i class="fas fa-bell"></i><span>Notifications</span></a>
</li>

<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('savings*') ? 'active' : '' }}">
    <a href="{{ route('admin.savings.index') }}"><i class="fas fa-piggy-bank"></i><span>@lang('Savings')</span></a>
</li>

<li class="{{ Request::is('analytics*') ? 'active' : '' }}">
    <a href="{{ route('admin.analytics.index') }}"><i class="fas fa-chart-line"></i><span>@lang('Analytics')</span></a>
</li>

<li class="{{ Request::is('settings*') ? 'active' : '' }}">
    <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i><span>@lang('Settings')</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{{ route('admin.categories.index') }}"><i class="fas fa-tags"></i><span>@lang('Categories')</span></a>
</li>