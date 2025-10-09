<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BPS Kota Semarang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #1e3a8a; /* Biru BPS */
            --secondary-color: #059669; /* Hijau BPS */
            --accent-color: #ea580c; /* Orange BPS */
            --light-blue: #3b82f6;
            --light-green: #10b981;
            --light-orange: #f97316;
        }
        
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Animasi fade-in untuk konten */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Sidebar dengan efek modern */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
            color: #333333;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(30, 58, 138, 0.1);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(30, 58, 138, 0.1);
            background: rgba(30, 58, 138, 0.05);
        }
        
        .sidebar-header h6 {
            color: #333333 !important;
            font-weight: 600;
        }
        
        .sidebar-header small {
            color: #666666 !important;
        }
        
        .logo-container {
            margin-bottom: 15px;
        }
        
        .logo-bps {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(30, 58, 138, 0.1);
        }
        
        .logo-bps img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
            transition: all 0.3s ease;
        }
        
        .logo-bps:hover img {
            transform: scale(1.05);
            filter: brightness(1.2);
        }
        
        .logo-bps::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(59, 130, 246, 0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
        }
        
        .sidebar-menu .nav-link {
            color: #333333;
            padding: 15px 20px;
            border-radius: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 2px 15px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-menu .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .sidebar-menu .nav-link:hover::before {
            left: 100%;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            color: white;
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .sidebar-menu .nav-link i {
            width: 20px;
            margin-right: 12px;
            transition: transform 0.3s ease;
        }
        
        .sidebar-menu .nav-link:hover i {
            transform: scale(1.1) rotate(5deg);
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(30, 58, 138, 0.1);
            background: rgba(30, 58, 138, 0.05);
        }
        
        .sidebar-footer .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #ffffff;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 20px 30px;
            border-radius: 0 0 20px 20px;
            margin: 0 20px 20px 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .top-navbar:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }
        
        .top-navbar .d-flex.align-items-center span {
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(30, 58, 138, 0.05);
        }
        
        .top-navbar .d-flex.align-items-center span:hover {
            background: rgba(30, 58, 138, 0.1);
            transform: translateY(-1px);
        }
        
        .top-navbar h5 {
            transition: all 0.3s ease;
        }
        
        .top-navbar:hover h5 {
            color: var(--primary-color);
        }
        
        .content-wrapper {
            padding: 30px;
            animation: fadeInUp 0.8s ease-out;
            background: #ffffff;
            border-radius: 20px;
            margin: 0 20px 20px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .content-wrapper:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
        
        /* Card dengan efek modern */
        .card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }
        
        /* Card dengan warna cerah BPS */
        .card.bright-bps {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px solid transparent;
            background-clip: padding-box;
            position: relative;
        }
        
        .card.bright-bps::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            padding: 2px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        }
        
        /* Card dengan efek glassmorphism cerah */
        .card.glass-bright {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(30, 58, 138, 0.1);
        }
        
        .card.glass-bright:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 12px 40px rgba(30, 58, 138, 0.15);
        }
        
        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Efek hover khusus untuk card di dashboard */
        .card .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover .btn {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: #333333;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 20px 25px;
            transition: all 0.3s ease;
        }
        
        .card:hover .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        }
        
        .card-body {
            background: #ffffff;
            padding: 25px;
        }
        
        .card-footer {
            background: #ffffff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        /* Ensure all cards are white and bright */
        .card,
        .card-body,
        .card-footer {
            background-color: #ffffff !important;
            color: #333333 !important;
        }
        
        /* Make all cards bright and modern */
        .card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
        }
        
        .card:hover {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%) !important;
            box-shadow: 0 12px 35px rgba(30, 58, 138, 0.12) !important;
        }
        
        /* Override any Bootstrap or other card styles */
        .card.bg-dark,
        .card.bg-secondary,
        .card.bg-light {
            background-color: #ffffff !important;
            color: #333333 !important;
        }
        
        .card-body.bg-dark,
        .card-body.bg-secondary,
        .card-body.bg-light {
            background-color: #ffffff !important;
            color: #333333 !important;
        }
        
        /* Card text colors */
        .card h1, .card h2, .card h3, .card h4, .card h5, .card h6 {
            color: #333333 !important;
        }
        
        .card p, .card span, .card div {
            color: #333333 !important;
        }
        
        /* Keep card header with white colors */
        .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            color: #333333 !important;
        }
        
        .card-header h1, .card-header h2, .card-header h3, 
        .card-header h4, .card-header h5, .card-header h6 {
            color: #333333 !important;
        }
        
        /* Ensure all cards use bright BPS colors */
        .card.bg-dark,
        .card.bg-secondary,
        .card.bg-light,
        .card.bg-primary,
        .card.bg-info,
        .card.bg-warning,
        .card.bg-danger,
        .card.bg-success {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%) !important;
            color: white !important;
        }
        
        /* Card with bright BPS gradient background */
        .card.bps-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            color: white !important;
        }
        
        /* Card with light BPS background */
        .card.bps-light {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--light-green) 100%) !important;
            color: var(--primary-color) !important;
        }
        
        /* Button styles dengan efek modern */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--light-green) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--light-orange) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(234, 88, 12, 0.4);
        }
        
        /* Action buttons in table */
        .table .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .table .btn:hover {
            transform: scale(1.1);
        }
        
        /* Stats card dengan efek modern */
        .stats-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 4s infinite;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(30, 58, 138, 0.3);
        }
        
        .stats-card .icon {
            font-size: 3rem;
            opacity: 0.9;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover .icon {
            transform: scale(1.1);
        }
        
        .stats-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stats-card .label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        /* Table styles */
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
            position: relative;
        }
        
        .table thead th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }
        
        .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.05), rgba(5, 150, 105, 0.05));
            transform: translateX(5px);
            box-shadow: 0 2px 10px rgba(30, 58, 138, 0.1);
        }
        
        .table tbody tr:last-child {
            border-bottom: none;
        }
        
        .table tbody tr:hover td {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        /* Alert styles */
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: slideInDown 0.5s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Alert hover effects */
        .alert:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        /* Pagination effects */
        .pagination .page-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 2px;
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }
        
        /* Footer effects */
        footer {
            transition: all 0.3s ease;
        }
        
        footer:hover {
            background-color: rgba(30, 58, 138, 0.05);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        /* Text selection */
        ::selection {
            background-color: var(--primary-color);
            color: white;
        }
        
        ::-moz-selection {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Focus states */
        *:focus {
            outline: none;
        }
        
        *:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
        
        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        /* Form controls */
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 12px 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            font-size: 14px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ffffff, #f8fafc);
        }
        
        .form-control:hover, .form-select:hover {
            border-color: var(--light-blue);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .form-label:hover {
            color: var(--light-blue);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        
        /* Form validation states */
        .form-control.is-valid {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        .form-control.is-invalid {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
            animation: shake 0.5s ease-out;
        }
        
        /* Filter card effects */
        .card .card-header h5 {
            transition: all 0.3s ease;
        }
        
        .card:hover .card-header h5 {
            transform: translateX(5px);
        }
        
        /* Modal styles */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
            padding: 20px 25px;
            position: relative;
        }
        
        .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background: rgba(248, 250, 252, 0.5);
        }
        
        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(0.8) translateY(-50px);
        }
        
        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }
        
        .modal-backdrop {
            transition: opacity 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .modal-backdrop.show {
            opacity: 0.6;
        }
        
        /* Tooltip and popover effects */
        .tooltip {
            transition: opacity 0.3s ease;
        }
        
        .popover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Dropdown menu effects */
        .dropdown-menu {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        .dropdown-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        
        .dropdown-item:hover {
            background-color: rgba(30, 58, 138, 0.1);
            transform: translateX(5px);
        }
        
        /* Badge and label effects */
        .badge {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        
        .badge:hover {
            transform: scale(1.1);
        }
        
        .label {
            transition: all 0.3s ease;
        }
        
        .label:hover {
            transform: translateY(-1px);
        }
        
        /* Progress bar effects */
        .progress {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .progress-bar {
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
        }
        
        .progress-bar-striped {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 1rem 1rem;
            animation: progress-bar-stripes 1s linear infinite;
        }
        
        @keyframes progress-bar-stripes {
            0% { background-position: 1rem 0; }
            100% { background-position: 0 0; }
        }
        
        /* Breadcrumb effects */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item {
            transition: all 0.3s ease;
        }
        
        .breadcrumb-item:hover {
            transform: translateY(-1px);
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--primary-color);
            font-weight: bold;
            margin: 0 8px;
        }
        
        /* List group effects */
        .list-group-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 0;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .list-group-item:hover {
            background-color: rgba(30, 58, 138, 0.05);
            transform: translateX(5px);
            border-color: var(--primary-color);
        }
        
        .list-group-item.active {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            border-color: var(--primary-color);
            color: white;
        }
        
        /* Panel and well effects */
        .panel {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .panel:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .well {
            border-radius: 12px;
            background: rgba(30, 58, 138, 0.05);
            border: 1px solid rgba(30, 58, 138, 0.1);
            transition: all 0.3s ease;
        }
        
        .well:hover {
            background: rgba(30, 58, 138, 0.1);
            border-color: var(--primary-color);
        }
        
        /* Jumbotron effects */
        .jumbotron {
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            color: white;
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
            transition: all 0.3s ease;
        }
        
        .jumbotron:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(30, 58, 138, 0.4);
        }
        
        /* Thumbnail effects */
        .thumbnail {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
        }
        
        .thumbnail:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Media object effects */
        .media {
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 12px;
        }
        
        .media:hover {
            background-color: rgba(30, 58, 138, 0.05);
            transform: translateX(5px);
        }
        
        .media-left, .media-right {
            transition: all 0.3s ease;
        }
        
        .media:hover .media-left,
        .media:hover .media-right {
            transform: scale(1.05);
        }
        
        /* Navbar effects */
        .navbar {
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-nav .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 2px;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(30, 58, 138, 0.1);
            transform: translateY(-1px);
        }
        
        /* Carousel effects */
        .carousel {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .carousel-item {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            transition: all 0.3s ease;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background: rgba(30, 58, 138, 0.8);
            border: none;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(30, 58, 138, 1);
            transform: scale(1.1);
        }
        
        /* Accordion effects */
        .accordion {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .accordion-item {
            transition: all 0.3s ease;
        }
        
        .accordion-button {
            transition: all 0.3s ease;
            border-radius: 0;
        }
        
        .accordion-button:hover {
            background-color: rgba(30, 58, 138, 0.05);
            transform: translateX(5px);
        }
        
        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            color: white;
        }
        
        /* Tabs effects */
        .nav-tabs {
            border-bottom: 2px solid rgba(30, 58, 138, 0.1);
        }
        
        .nav-tabs .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px 8px 0 0;
            margin-right: 2px;
            border: none;
            background: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            background-color: rgba(30, 58, 138, 0.1);
            border-color: transparent;
            transform: translateY(-2px);
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Pills effects */
        .nav-pills .nav-link {
            transition: all 0.3s ease;
            border-radius: 20px;
            margin: 2px;
            border: none;
        }
        
        .nav-pills .nav-link:hover {
            background-color: rgba(30, 58, 138, 0.1);
            transform: translateY(-1px);
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--light-blue));
            color: white;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        /* Spinner effects */
        .spinner-border {
            border-width: 3px;
            border-color: var(--primary-color);
            border-right-color: transparent;
        }
        
        .spinner-grow {
            background-color: var(--primary-color);
        }
        
        .spinner-border-sm {
            border-width: 2px;
        }
        
        .spinner-grow-sm {
            width: 1rem;
            height: 1rem;
        }
        
        /* Close button effects */
        .btn-close {
            transition: all 0.3s ease;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-close:hover {
            background-color: rgba(30, 58, 138, 0.1);
            transform: scale(1.1);
        }
        
        .btn-close:focus {
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        
        /* Figure effects */
        .figure {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .figure:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .figure-caption {
            transition: all 0.3s ease;
            background: rgba(30, 58, 138, 0.05);
            padding: 10px;
            border-radius: 0 0 12px 12px;
        }
        
        .figure:hover .figure-caption {
            background: rgba(30, 58, 138, 0.1);
        }
        
        /* Blockquote effects */
        .blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 20px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .blockquote:hover {
            border-left-width: 8px;
            transform: translateX(5px);
        }
        
        .blockquote-footer {
            color: var(--primary-color);
            font-style: italic;
        }
        
        /* Code effects */
        code {
            background-color: rgba(30, 58, 138, 0.1);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            transition: all 0.3s ease;
        }
        
        code:hover {
            background-color: rgba(30, 58, 138, 0.2);
            transform: scale(1.05);
        }
        
        pre {
            background-color: rgba(30, 58, 138, 0.05);
            border: 1px solid rgba(30, 58, 138, 0.1);
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        pre:hover {
            background-color: rgba(30, 58, 138, 0.1);
            border-color: var(--primary-color);
        }
        
        /* KBD effects */
        kbd {
            background-color: var(--primary-color);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.875em;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        kbd:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        /* Samp effects */
        samp {
            background-color: rgba(30, 58, 138, 0.1);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            transition: all 0.3s ease;
        }
        
        samp:hover {
            background-color: rgba(30, 58, 138, 0.2);
            transform: scale(1.05);
        }
        
        /* Var effects */
        var {
            color: var(--primary-color);
            font-style: italic;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        var:hover {
            color: var(--secondary-color);
            transform: scale(1.05);
        }
        
        /* Mark effects */
        mark {
            background-color: rgba(234, 88, 12, 0.2);
            color: var(--accent-color);
            padding: 2px 4px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        mark:hover {
            background-color: rgba(234, 88, 12, 0.3);
            transform: scale(1.05);
        }
        
        /* Small effects */
        small {
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        small:hover {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        /* Strong effects */
        strong {
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        strong:hover {
            color: var(--secondary-color);
            transform: scale(1.02);
        }
        
        /* Em effects */
        em {
            color: var(--accent-color);
            transition: all 0.3s ease;
        }
        
        em:hover {
            color: var(--primary-color);
            transform: scale(1.02);
        }
        
        /* Del effects */
        del {
            color: #6c757d;
            text-decoration: line-through;
            transition: all 0.3s ease;
        }
        
        del:hover {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        /* Ins effects */
        ins {
            color: var(--secondary-color);
            text-decoration: underline;
            transition: all 0.3s ease;
        }
        
        ins:hover {
            color: var(--primary-color);
            text-decoration: none;
            background-color: rgba(5, 150, 105, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* U effects */
        u {
            color: var(--primary-color);
            text-decoration: underline;
            transition: all 0.3s ease;
        }
        
        u:hover {
            color: var(--secondary-color);
            text-decoration: none;
            background-color: rgba(30, 58, 138, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Abbr effects */
        abbr {
            color: var(--accent-color);
            text-decoration: dotted underline;
            transition: all 0.3s ease;
        }
        
        abbr:hover {
            color: var(--primary-color);
            text-decoration: none;
            background-color: rgba(234, 88, 12, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Acronym effects */
        acronym {
            color: var(--secondary-color);
            text-decoration: dotted underline;
            transition: all 0.3s ease;
        }
        
        acronym:hover {
            color: var(--primary-color);
            text-decoration: none;
            background-color: rgba(5, 150, 105, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Dfn effects */
        dfn {
            color: var(--primary-color);
            font-style: italic;
            transition: all 0.3s ease;
        }
        
        dfn:hover {
            color: var(--secondary-color);
            background-color: rgba(30, 58, 138, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Cite effects */
        cite {
            color: var(--accent-color);
            font-style: italic;
            transition: all 0.3s ease;
        }
        
        cite:hover {
            color: var(--primary-color);
            background-color: rgba(234, 88, 12, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Q effects */
        q {
            color: var(--secondary-color);
            font-style: italic;
            transition: all 0.3s ease;
        }
        
        q:hover {
            color: var(--primary-color);
            background-color: rgba(5, 150, 105, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Time effects */
        time {
            color: var(--accent-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        time:hover {
            color: var(--primary-color);
            background-color: rgba(234, 88, 12, 0.1);
            padding: 2px 4px;
            border-radius: 4px;
        }
        
        /* Address effects */
        address {
            color: var(--primary-color);
            font-style: italic;
            transition: all 0.3s ease;
        }
        
        address:hover {
            color: var(--secondary-color);
            background-color: rgba(30, 58, 138, 0.1);
            padding: 5px 10px;
            border-radius: 8px;
        }
        
        /* HR effects */
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            margin: 30px 0;
            border-radius: 1px;
            transition: all 0.3s ease;
        }
        
        hr:hover {
            height: 4px;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.3);
        }
        
        /* Loading animation */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .loading.hidden {
            opacity: 0;
            transform: scale(1.1);
            pointer-events: none;
        }
        
        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            position: relative;
        }
        
        .spinner::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border: 2px solid transparent;
            border-top: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: spin 1.5s linear infinite reverse;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Chart container effects */
        .chart-container {
            position: relative;
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .chart-container:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
        }
        
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            z-index: 1;
        }
        
        /* Statistik cards hover effect */
        .border.rounded.p-3:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .border.rounded.p-3:hover i {
            transform: scale(1.1);
        }
        
        .border.rounded.p-3 i {
            transition: transform 0.3s ease;
        }
        
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 100vw;
            }
            
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                z-index: 9999;
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
                color: #333333;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .top-navbar {
                margin: 0 10px 10px 10px;
                padding: 15px 20px;
            }
            
            .content-wrapper {
                padding: 20px 15px;
            }
            
            .card {
                margin-bottom: 20px;
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
            
            .card:hover {
                transform: translateY(-3px) scale(1.01);
            }
            
            .btn {
                padding: 10px 16px;
                font-size: 14px;
            }
            
            .btn:hover {
                transform: translateY(-1px);
            }
            
            .logo-bps {
                width: 60px;
                height: 60px;
            }
            
            .sidebar-header h6 {
                font-size: 16px;
            }
            
            .sidebar-header small {
                font-size: 12px;
            }
            
            .nav-link {
                padding: 12px 15px !important;
                font-size: 14px;
            }
            
            .nav-link i {
                width: 18px;
                margin-right: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .content-wrapper {
                padding: 15px 10px;
            }
            
            .top-navbar {
                margin: 0 5px 5px 5px;
                padding: 12px 15px;
            }
            
            .top-navbar h5 {
                font-size: 18px;
            }
            
            .card-header {
                padding: 15px 20px;
            }
            
            .card {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
            
            .btn {
                padding: 8px 12px;
                font-size: 13px;
            }
            
            .logo-bps {
                width: 50px;
                height: 50px;
            }
        }
        
        @media print {
            .sidebar, .top-navbar, .btn, .loading {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
                color: #ffffff;
            }
            
            .sidebar {
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%) !important;
                color: #333333 !important;
            }
            
            .card {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
            
            .card-header {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
            
            .card-body {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
            
            .card-footer {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
            
            .top-navbar {
                background-color: #2d2d2d;
                color: #ffffff;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .card {
                border: 2px solid #000000;
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
            
            .card-header {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
            
            .card-body {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
            }
            
            .btn {
                border: 2px solid #000000;
            }
            
            .table {
                border: 2px solid #000000;
            }
        }
        
        /* Landscape orientation support */
        @media (orientation: landscape) and (max-height: 500px) {
            .sidebar {
                width: 200px;
            }
            
            .main-content {
                margin-left: 200px;
            }
            
            .content-wrapper {
                padding: 15px;
            }
            
            .card {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
        }
        
        /* Portrait orientation support */
        @media (orientation: portrait) and (max-width: 768px) {
            .card {
                margin-bottom: 15px;
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
                color: #333333 !important;
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.08) !important;
            }
            
            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
        
        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Hamburger button styles */
        #sidebarToggle {
            background: none;
            border: none;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        #sidebarToggle:hover {
            background: rgba(30, 58, 138, 0.1);
            transform: scale(1.1);
        }
        
        #sidebarToggle:active {
            transform: scale(0.95);
        }
        
        /* Smooth hover transitions */
        .card, .btn, .nav-link, .form-control, .form-select, .alert, .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Hover effects for interactive elements */
        .card:hover, .btn:hover, .nav-link:hover, .alert:hover {
            transform: translateY(-2px);
        }
        
        /* Active states */
        .btn:active, .nav-link:active {
            transform: translateY(0);
        }
        
        /* Loading states with smooth transitions */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Success states with animations */
        .alert-success {
            border-left: 4px solid var(--secondary-color);
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Error states with animations */
        .alert-danger {
            border-left: 4px solid var(--accent-color);
            animation: shake 0.5s ease-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        /* Info states with animations */
        .alert-info {
            border-left: 4px solid var(--primary-color);
            animation: pulse 0.5s ease-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        /* Warning states with animations */
        .alert-warning {
            border-left: 4px solid var(--accent-color);
            animation: bounce 0.5s ease-out;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>
    
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
         <style>
        .sidebar {
            height: 100vh;           
            overflow-y: auto;        
            overflow-x: hidden;      
            background-color: #343a40; 
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-bps">
                    <img src="{{ asset('images/ChatGPT Image Aug 1, 2025, 09_36_38 AM.png') }}" alt="BPS Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'; this.nextElementSibling.style.color='white';">
                    <i class="fas fa-chart-bar fa-2x text-white" style="display: none; color: white !important;"></i>
                </div>
            </div>
            <h6 class="mb-0">BPS Kota Semarang</h6>
            <small>Sistem Informasi Statistik</small>
        </div>
        
        <div class="sidebar-menu">
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('penduduk') ? 'active' : '' }}" href="{{ route('penduduk') }}">
                    <i class="fas fa-users"></i>Penduduk
                </a>
                <a class="nav-link {{ request()->routeIs('tenaga-kerja') ? 'active' : '' }}" href="{{ route('tenaga-kerja') }}">
                    <i class="fas fa-briefcase"></i>Tenaga Kerja
                </a>
                <a class="nav-link {{ request()->routeIs('ginimenu') ? 'active' : '' }}" href="{{ route('ginimenu') }}">
                    <i class="fas fa-heart"></i>IPM,IPG dan IDG
                </a>
                <a class="nav-link {{ request()->routeIs('gini-rasio') ? 'active' : '' }}" href="{{ route('gini-rasio') }}">
                    <i class="fas fa-chart-line"></i>Gini Rasio dan Kemiskinan
                </a>
             <a class="nav-link {{ request()->routeIs('inflasidata') ? 'active' : ''}}" href="{{ route('inflasi.data') }}">
                    <i class="fas fa-money-bill-wave"></i>Inflasi
            </a>
            <a class="nav-link{{ request()->routeIs('produk-domestik-bruto') ? 'active' : '' }}" href="{{ url('pendidikan') }}">
                    <i class="fas fa-industrial"></i>Pendidikan 
            </a>
            <a class="nav-link{{ request()->routeIs('ekonomi')? 'active': '' }}" href="{{ url('ekonomi') }}">
                    <i class="fas fa-industrial"></i>Ekonomi
            </a>

            </nav>
        </div>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link d-md-none me-3" id="sidebarToggle" style="color: var(--primary-color); text-decoration: none;">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                        <small class="text-muted">@yield('page-subtitle', 'Selamat datang di sistem informasi statistik BPS Kota Semarang')</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-3">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading screen
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            setTimeout(() => {
                loading.classList.add('hidden');
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 300);
            }, 500);
        });
        
        // Mobile sidebar control
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle && sidebar && sidebarOverlay) {
                // Toggle sidebar
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                });
                
                // Close sidebar when clicking overlay
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                });
                
                // Close sidebar when clicking nav links on mobile
                const navLinks = sidebar.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('show');
                            sidebarOverlay.classList.remove('show');
                            document.body.style.overflow = '';
                        }
                    });
                });
                
                // Close sidebar on window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            }
        });
        
        // Smooth scrolling untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Efek hover untuk card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Add touch support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 768) {
                // Swipe right to open sidebar
                if (touchEndX - touchStartX > 50 && touchStartX < 50) {
                    sidebar.classList.add('show');
                    sidebarOverlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
                // Swipe left to close sidebar
                else if (touchStartX - touchEndX > 50 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html> 