@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="page__heading">Admin Dashboard</h1>
    </div>
    
    <div class="section-body">
        <!-- Overview Cards Row -->
        <div class="row">
            <!-- Total Balance Card -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total System Balance</h4>
                        </div>
                        <div class="card-body">
                            UGX {{ number_format($totalSavings, 0) }}
                        </div>
                        <div class="card-footer">
                            @if($balanceGrowth > 0)
                                <small class="text-success">+{{ number_format($balanceGrowth, 1) }}% from last month</small>
                            @elseif($balanceGrowth < 0)
                                <small class="text-danger">{{ number_format($balanceGrowth, 1) }}% from last month</small>
                            @else
                                <small class="text-muted">No change from last month</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Active Users Card -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Active Users</h4>
                        </div>
                        <div class="card-body">
                            {{ $activeUsers }}
                        </div>
                        <div class="card-footer">
                            @if($newUsersPercentage > 0)
                                <small class="text-success">+{{ number_format($newUsersPercentage, 1) }}% from last month</small>
                            @elseif($newUsersPercentage < 0)
                                <small class="text-danger">{{ number_format($newUsersPercentage, 1) }}% from last month</small>
                            @else
                                <small class="text-muted">No change from last month</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Withdrawals Card -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Withdrawals</h4>
                        </div>
                        <div class="card-body">
                            UGX {{ number_format($totalWithdrawals, 0) }}
                        </div>
                        <div class="card-footer">
                            @if(isset($withdrawalTrend) && $withdrawalTrend > 0)
                                <small class="text-danger">+{{ number_format($withdrawalTrend, 1) }}% from last month</small>
                            @elseif(isset($withdrawalTrend) && $withdrawalTrend < 0)
                                <small class="text-success">{{ number_format($withdrawalTrend, 1) }}% from last month</small>
                            @else
                                <small class="text-muted">Last 30 days</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Transactions Count Card -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transactions</h4>
                        </div>
                        <div class="card-body">
                            {{ $transactionCount }}
                        </div>
                        <div class="card-footer">
                            @if(isset($transactionTrend) && $transactionTrend > 0)
                                <small class="text-success">+{{ number_format($transactionTrend, 1) }}% from last month</small>
                            @elseif(isset($transactionTrend) && $transactionTrend < 0)
                                <small class="text-danger">{{ number_format($transactionTrend, 1) }}% from last month</small>
                            @else
                                <small class="text-muted">Last 30 days</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
            <!-- Money Flow Chart -->
            <div class="col-lg-8 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>System Money Flow</h4>
                        <div class="card-header-action">
                            <div class="btn-group">
                                <button class="btn btn-primary active" id="monthly-flow">Monthly</button>
                                <button class="btn btn-primary" id="weekly-flow">Weekly</button>
                                <button class="btn btn-primary" id="yearly-flow">Yearly</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="moneyFlowChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Transaction Types Breakdown -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Transaction Breakdown</h4>
                        <div class="card-header-action">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="periodDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Last 30 Days
                                </button>
                                <div class="dropdown-menu" aria-labelledby="periodDropdown">
                                    <a class="dropdown-item period-select" href="#" data-period="30">Last 30 Days</a>
                                    <a class="dropdown-item period-select" href="#" data-period="90">Last Quarter</a>
                                    <a class="dropdown-item period-select" href="#" data-period="365">Year to Date</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="transactionTypesChart" height="330"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Users and Activities Row -->
        <div class="row">
            <!-- Active Users List -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Top Active Users</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                <i class="fas fa-users"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-img" style="width:35px; height:35px; border-radius:50%; background-color: #{{ substr(md5($user->email), 0, 6) }}; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; margin-right:10px;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>UGX {{ number_format($user->account_balance, 0) }}</td>
                                        <td>
                                            <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="userActionDropdown{{ $user->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userActionDropdown{{ $user->id }}">
                                                    <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                                        <i class="fas fa-eye text-primary"></i> View Details
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                                                        <i class="fas fa-edit text-info"></i> Edit User
                                                    </a>
                                                    @if($user->status == 'active')
                                                        <a class="dropdown-item user-status-toggle" href="#" data-user-id="{{ $user->id }}" data-status="inactive">
                                                            <i class="fas fa-ban text-warning"></i> Deactivate
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item user-status-toggle" href="#" data-user-id="{{ $user->id }}" data-status="active">
                                                            <i class="fas fa-check-circle text-success"></i> Activate
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Saving Goals -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Saving Goals</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.savingGoals.index') }}" class="btn btn-primary">
                                <i class="fas fa-bullseye"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($savingGoals ?? []) > 0)
                            @foreach($savingGoals as $goal)
                            <?php
                                $goalCategory = 'other';
                                $nameLower = strtolower($goal->name ?? '');
                                if (stripos($nameLower, 'emergency') !== false) {
                                    $goalCategory = 'emergency';
                                } elseif (stripos($nameLower, 'travel') !== false) {
                                    $goalCategory = 'travel';
                                } elseif (stripos($nameLower, 'education') !== false) {
                                    $goalCategory = 'education';
                                } elseif (stripos($nameLower, 'car') !== false) {
                                    $goalCategory = 'car';
                                } elseif (stripos($nameLower, 'house') !== false) {
                                    $goalCategory = 'house';
                                }
                            ?>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $goal->name }}</h6>
                                        <small class="text-muted">{{ $goal->user->name }} • UGX {{ number_format($goal->current_amount, 0) }} of UGX {{ number_format($goal->target_amount, 0) }}</small>
                                    </div>
                                    <div>
                                        <span class="badge bg-primary">{{ round(($goal->current_amount / $goal->target_amount) * 100) }}%</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ ($goal->current_amount / $goal->target_amount) * 100 }}%; background-color: 
                                        @if($goalCategory == 'emergency') #dc3545
                                        @elseif($goalCategory == 'travel') #17a2b8
                                        @elseif($goalCategory == 'education') #6610f2
                                        @elseif($goalCategory == 'car') #fd7e14
                                        @elseif($goalCategory == 'house') #28a745
                                        @else #007bff
                                        @endif"
                                        aria-valuenow="{{ ($goal->current_amount / $goal->target_amount) * 100 }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-between">
                                    <small class="text-muted">
                                        @if($goal->deadline)
                                            Deadline: {{ $goal->deadline->format('M d, Y') }}
                                        @else
                                            No deadline set
                                        @endif
                                    </small>
                                    <small class="
                                        @if($goal->deadline && now()->diffInDays($goal->deadline, false) < 0)
                                            text-danger
                                        @elseif($goal->deadline && now()->diffInDays($goal->deadline, false) < 30)
                                            text-warning
                                        @else
                                            text-success
                                        @endif
                                    ">
                                        @if($goal->deadline)
                                            @if(now()->diffInDays($goal->deadline, false) < 0)
                                                Overdue by {{ now()->diffInDays($goal->deadline) }} days
                                            @else
                                                {{ now()->diffInDays($goal->deadline) }} days left
                                            @endif
                                        @endif
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-bullseye fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted">No saving goals found in the system</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Recent Withdrawals -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Withdrawals</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-primary">
                                <i class="fas fa-money-bill-wave"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentWithdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal->user->name }}</td>
                                        <td class="text-danger">
                                            -UGX {{ number_format($withdrawal->amount, 0) }}
                                        </td>
                                        <td>{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($withdrawal->status == 'pending') bg-warning 
                                                @elseif($withdrawal->status == 'completed') bg-success 
                                                @elseif($withdrawal->status == 'rejected') bg-danger 
                                                @else bg-secondary 
                                                @endif">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($withdrawal->status == 'pending')
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success withdrawal-action" data-id="{{ $withdrawal->id }}" data-action="approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger withdrawal-action" data-id="{{ $withdrawal->id }}" data-action="reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Analytics -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Category Analytics</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.savingGoals.index') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($categoryAnalytics) > 0)
                            @foreach($categoryAnalytics as $category => $count)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0">{{ ucfirst($category) }}</h6>
                                        <small class="text-muted">Goals: {{ $count }}</small>
                                    </div>
                                    <div>
                                        <span class="badge bg-info">{{ $count }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-list fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted">No category data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Savings Analytics -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Savings Analytics</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.savings.index') }}" class="btn btn-primary">
                                <i class="fas fa-piggy-bank"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Total Target Amount</h6>
                            <p class="mb-0">UGX {{ number_format($totalTargetAmount, 0) }}</p>
                        </div>
                        <div class="mb-3">
                            <h6>Total Current Amount</h6>
                            <p class="mb-0">UGX {{ number_format($totalCurrentAmount, 0) }}</p>
                            <small class="text-muted">
                                @if($savingsGrowth > 0)
                                    <span class="text-success">+{{ number_format($savingsGrowth, 1) }}% from last month</span>
                                @elseif($savingsGrowth < 0)
                                    <span class="text-danger">{{ number_format($savingsGrowth, 1) }}% from last month</span>
                                @else
                                    <span class="text-muted">No change from last month</span>
                                @endif
                            </small>
                        </div>
                        <div class="mb-3">
                            <h6>Progress Toward Goals</h6>
                            <p class="mb-0">{{ number_format($savingsProgress, 1) }}%</p>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $savingsProgress }}%;" 
                                     aria-valuenow="{{ $savingsProgress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Analytics -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Settings Analytics</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-primary">
                                <i class="fas fa-cogs"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Settings Changes</h6>
                            <p class="mb-0">{{ $settingsChangesCount }} Changes</p>
                            <small class="text-muted">
                                @if($settingsChangeTrend > 0)
                                    <span class="text-success">+{{ number_format($settingsChangeTrend, 1) }}% from last month</span>
                                @elseif($settingsChangeTrend < 0)
                                    <span class="text-danger">{{ number_format($settingsChangeTrend, 1) }}% from last month</span>
                                @else
                                    <span class="text-muted">No change from last month</span>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- All Transactions Row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Recent System Transactions</h4>
                        <div>
                            <div class="input-group date-range-picker">
                                <input type="text" class="form-control" id="transaction-date-range" placeholder="Select date range">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="transaction-filters mb-3">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <select class="form-control" id="transaction-type-filter">
                                        <option value="">All Transaction Types</option>
                                        <option value="savings">Savings</option>
                                        <option value="expense">Expense</option>
                                        <option value="withdrawal">Withdrawal</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-control" id="transaction-status-filter">
                                        <option value="">All Statuses</option>
                                        <option value="completed">Completed</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <select class="form-control" id="transaction-category-filter">
                                        <option value="">All Categories</option>
                                        <option value="Salary">Salary</option>
                                        <option value="Deposit">Deposit</option>
                                        <option value="Food">Food</option>
                                        <option value="Entertainment">Entertainment</option>
                                        <option value="Transport">Transport</option>
                                        <option value="Bills">Bills</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="transaction-search" placeholder="Search...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="transaction-search-btn">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="transactions-table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Transaction</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr class="transaction-row" 
                                        data-type="{{ $transaction['type'] }}" 
                                        data-status="{{ $transaction['status'] }}" 
                                        data-category="{{ $transaction['category'] }}">
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar mr-2" style="background-color: 
                                                    @if($transaction['type'] == 'income')
                                                        @if($transaction['category'] == 'Salary') #ebf7e3
                                                        @elseif($transaction['category'] == 'Deposit') #e3f0d1
                                                        @else #d1e7c5
                                                        @endif
                                                    @elseif($transaction['type'] == 'expense')
                                                        @if($transaction['category'] == 'Food') #fbe9e7
                                                        @elseif($transaction['category'] == 'Entertainment') #ffebee
                                                        @elseif($transaction['category'] == 'Transport') #f3e5f5
                                                        @elseif($transaction['category'] == 'Bills') #e1f5fe
                                                        @else #e8eaf6
                                                        @endif
                                                    @elseif($transaction['type'] == 'withdrawal')
                                                        #fadbd8
                                                    @else
                                                        #e8eaf6
                                                    @endif
                                                ;">
                                                    <div class="avatar-title" style="color: 
                                                        @if($transaction['type'] == 'income') 
                                                            #28a745
                                                        @elseif($transaction['type'] == 'expense') 
                                                            @if($transaction['category'] == 'Food') #e74c3c
                                                            @elseif($transaction['category'] == 'Entertainment') #d32f2f
                                                            @elseif($transaction['category'] == 'Transport') #9c27b0
                                                            @elseif($transaction['category'] == 'Bills') #0288d1
                                                            @else #3f51b5
                                                            @endif
                                                        @elseif($transaction['type'] == 'withdrawal')
                                                            #e74c3c
                                                        @else
                                                            #3f51b5
                                                        @endif
                                                    ;">
                                                        {{ substr($transaction['description'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>{{ $transaction['description'] }}</div>
                                            </div>
                                        </td>
                                        <td class="{{ $transaction['type'] == 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction['type'] == 'income' ? '+' : '-' }}UGX {{ number_format($transaction['amount'], 0) }}
                                        </td>
                                        <td>{{ $transaction['date']->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="badge" style="background-color: 
                                                @if($transaction['type'] == 'income')
                                                    #e3f0d1; color: #6A8A30;
                                                @elseif($transaction['type'] == 'expense')
                                                    @if($transaction['category'] == 'Food') #fbe9e7; color: #c0392b;
                                                    @elseif($transaction['category'] == 'Entertainment') #ffebee; color: #b71c1c;
                                                    @elseif($transaction['category'] == 'Transport') #f3e5f5; color: #7b1fa2;
                                                    @elseif($transaction['category'] == 'Bills') #e1f5fe; color: #0277bd;
                                                    @else #e8eaf6; color: #303f9f;
                                                    @endif
                                                @elseif($transaction['type'] == 'withdrawal')
                                                    #fadbd8; color: #c0392b;
                                                @else
                                                    #e8eaf6; color: #303f9f;
                                                @endif
                                            ">
                                                {{ $transaction['category'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($transaction['status'] == 'pending') bg-warning 
                                                @elseif($transaction['status'] == 'completed') bg-success 
                                                @elseif($transaction['status'] == 'rejected') bg-danger 
                                                @else bg-secondary 
                                                @endif">
                                                {{ ucfirst($transaction['status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="txnActionDropdown{{ $transaction['id'] }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="txnActionDropdown{{ $transaction['id'] }}">
                                                    <a class="dropdown-item" href="{{ route('admin.transactions.show', $transaction['id']) }}">
                                                        <i class="fas fa-eye text-primary"></i> View Details
                                                    </a>
                                                    @if($transaction['status'] == 'pending')
                                                        <a class="dropdown-item transaction-status-update" href="#" data-id="{{ $transaction['id'] }}" data-status="completed">
                                                            <i class="fas fa-check-circle text-success"></i> Approve
                                                        </a>
                                                        <a class="dropdown-item transaction-status-update" href="#" data-id="{{ $transaction['id'] }}" data-status="rejected">
                                                            <i class="fas fa-times-circle text-danger"></i> Reject
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <nav aria-label="Transaction pagination">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-primary">View All Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded. Please ensure the script is included.');
        return;
    }

    // Debug: Check canvas elements
    const moneyFlowCanvas = document.getElementById('moneyFlowChart');
    const transactionTypesCanvas = document.getElementById('transactionTypesChart');
    if (!moneyFlowCanvas || !transactionTypesCanvas) {
        console.error('Canvas elements for charts not found.');
        return;
    }

    // Data from Laravel
    const weeklyData = @json($weeklyData);
    const monthlyData = @json($monthlyData);
    const yearlyData = @json($yearlyData);
    let transactionTypeData = @json($transactionTypeData);

    // Debug: Log data to ensure it's correct
    console.log('Weekly Data:', weeklyData);
    console.log('Monthly Data:', monthlyData);
    console.log('Yearly Data:', yearlyData);
    console.log('Transaction Type Data:', transactionTypeData);

    // Initialize System Money Flow Chart
    let moneyFlowChart;
    try {
        const moneyFlowCtx = moneyFlowCanvas.getContext('2d');
        moneyFlowChart = new Chart(moneyFlowCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(monthlyData),
                datasets: [
                    {
                        label: 'Deposits',
                        data: Object.values(monthlyData).map(item => item.deposits || 0),
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: 'Withdrawals',
                        data: Object.values(monthlyData).map(item => item.withdrawals || 0),
                        backgroundColor: '#dc3545',
                        borderColor: '#dc3545',
                        borderWidth: 1
                    },
                    {
                        label: 'Net Flow',
                        data: Object.values(monthlyData).map(item => (item.deposits || 0) - (item.withdrawals || 0)),
                        type: 'line',
                        backgroundColor: 'rgba(75, 192, 192, 0.4)',
                        borderColor: '#17a2b8',
                        borderWidth: 2,
                        pointBackgroundColor: '#17a2b8',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'UGX ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'UGX ' + context.parsed.y.toLocaleString();
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
        console.log('Money Flow Chart initialized successfully');
    } catch (error) {
        console.error('Error initializing Money Flow Chart:', error);
    }

    // Initialize Transaction Types Chart
    let transactionTypesChart;
    try {
        const transactionTypesCtx = transactionTypesCanvas.getContext('2d');
        transactionTypesChart = new Chart(transactionTypesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Deposits', 'Withdrawals', 'Transfers', 'Savings'],
                datasets: [{
                    data: [
                        transactionTypeData.deposits || 0,
                        transactionTypeData.withdrawals || 0,
                        transactionTypeData.transfers || 0,
                        transactionTypeData.savings || 0
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#17a2b8',
                        '#6610f2'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    label += value + ' (' + percentage + '%)';
                                }
                                return label;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
        console.log('Transaction Types Chart initialized successfully');
    } catch (error) {
        console.error('Error initializing Transaction Types Chart:', error);
    }

    // Date Range Picker for Transactions Table
    try {
        $('#transaction-date-range').daterangepicker({
            opens: 'left',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: 'MMM D, YYYY'
            }
        }, function(start, end, label) {
            filterTransactions();
        });
    } catch (error) {
        console.error('Error initializing Date Range Picker:', error);
    }

    // Transaction Filters
    $('#transaction-type-filter, #transaction-status-filter, #transaction-category-filter').on('change', function() {
        filterTransactions();
    });

    $('#transaction-search-btn').on('click', function() {
        filterTransactions();
    });

    $('#transaction-search').on('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTransactions();
        }
    });

    function filterTransactions() {
        const type = $('#transaction-type-filter').val();
        const status = $('#transaction-status-filter').val();
        const category = $('#transaction-category-filter').val();
        const search = $('#transaction-search').val().toLowerCase();
        const dateRange = $('#transaction-date-range').val();
        
        $('.transaction-row').each(function() {
            const $row = $(this);
            const rowType = $row.data('type');
            const rowStatus = $row.data('status');
            const rowCategory = $row.data('category');
            const rowText = $row.text().toLowerCase();
            
            const typeMatch = !type || rowType === type;
            const statusMatch = !status || rowStatus === status;
            const categoryMatch = !category || rowCategory === category;
            const searchMatch = !search || rowText.includes(search);
            
            if (typeMatch && statusMatch && categoryMatch && searchMatch) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    }

    // Money Flow Chart Button Handlers
    const updateMoneyFlowChart = (period) => {
        if (!moneyFlowChart) {
            console.error('Money Flow Chart not initialized');
            return;
        }
        let data;
        if (period === 'weekly') {
            data = weeklyData;
        } else if (period === 'monthly') {
            data = monthlyData;
        } else if (period === 'yearly') {
            data = yearlyData;
        } else {
            data = monthlyData; // Default to monthly
        }

        console.log(`Updating Money Flow Chart to ${period}:`, data);

        moneyFlowChart.data.labels = Object.keys(data);
        moneyFlowChart.data.datasets[0].data = Object.values(data).map(item => item.deposits || 0);
        moneyFlowChart.data.datasets[1].data = Object.values(data).map(item => item.withdrawals || 0);
        moneyFlowChart.data.datasets[2].data = Object.values(data).map(item => (item.deposits || 0) - (item.withdrawals || 0));
        moneyFlowChart.update();
    };

    $('#weekly-flow').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        updateMoneyFlowChart('weekly');
    });

    $('#monthly-flow').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        updateMoneyFlowChart('monthly');
    });

    $('#yearly-flow').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        updateMoneyFlowChart('yearly');
    });

    // Transaction Types Chart Period Handler
    const updateTransactionTypesChart = (period) => {
        if (!transactionTypesChart) {
            console.error('Transaction Types Chart not initialized');
            return;
        }

        let deposits = transactionTypeData.deposits || 0;
        let withdrawals = transactionTypeData.withdrawals || 0;
        let transfers = transactionTypeData.transfers || 0;
        let savings = transactionTypeData.savings || 0;

        if (period === '90') {
            deposits = Math.round(deposits * 3);
            withdrawals = Math.round(withdrawals * 3);
            transfers = Math.round(transfers * 3);
            savings = Math.round(savings * 3);
        } else if (period === '365') {
            deposits = Math.round(deposits * 12);
            withdrawals = Math.round(withdrawals * 12);
            transfers = Math.round(transfers * 12);
            savings = Math.round(savings * 12);
        }

        const newData = [deposits, withdrawals, transfers, savings];
        console.log(`Updating Transaction Types Chart for period ${period}:`, newData);

        transactionTypesChart.data.datasets[0].data = newData;
        transactionTypesChart.update();
    };

    $('.period-select').on('click', function(e) {
        e.preventDefault();
        const period = $(this).data('period');
        $('#periodDropdown').text($(this).text());
        updateTransactionTypesChart(period);
    });

    // Other Event Handlers
    $('.user-status-toggle').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const newStatus = $(this).data('status');
        alert(`User #${userId} status would be changed to ${newStatus}`);
        const $row = $(this).closest('tr');
        const $statusBadge = $row.find('td:eq(2) .badge');
        if (newStatus === 'active') {
            $statusBadge.removeClass('bg-warning').addClass('bg-success').text('Active');
            $(this).data('status', 'inactive').html('<i class="fas fa-ban text-warning"></i> Deactivate');
        } else {
            $statusBadge.removeClass('bg-success').addClass('bg-warning').text('Inactive');
            $(this).data('status', 'active').html('<i class="fas fa-check-circle text-success"></i> Activate');
        }
    });

    $('.withdrawal-action').on('click', function() {
        const id = $(this).data('id');
        const action = $(this).data('action');
        alert(`Withdrawal #${id} would be ${action}d`);
        const $row = $(this).closest('tr');
        const $statusCell = $row.find('td:eq(3)');
        const $actionsCell = $row.find('td:eq(4)');
        if (action === 'approve') {
            $statusCell.html('<span class="badge bg-success">Completed</span>');
        } else {
            $statusCell.html('<span class="badge bg-danger">Rejected</span>');
        }
        $actionsCell.html('');
    });

    $('.transaction-status-update').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        alert(`Transaction #${id} status would be changed to ${status}`);
        const $row = $(this).closest('tr');
        const $statusCell = $row.find('td:eq(5)');
        if (status === 'completed') {
            $statusCell.html('<span class="badge bg-success">Completed</span>');
        } else if (status === 'rejected') {
            $statusCell.html('<span class="badge bg-danger">Rejected</span>');
        }
        $(this).closest('.dropdown-menu').parent().remove();
    });
});
</script>
@endpush
@endsection