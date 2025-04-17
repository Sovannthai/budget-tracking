<style>
    :root {
        --primary: #292525;
        --secondary: #000;
        --success: #4cc9f0;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] {
        --primary: #292525;
        --secondary: #333;
        --light: #292525;
        --dark: #f8f9fa;
        --gray: #adb5bd;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f7ff;
        color: var(--dark);
        transition: all 0.3s ease;
    }

    body[data-theme="dark"] {
        background-color: #121212;
        color: var(--dark);
    }

    .container {
        margin: 0 auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    body[data-theme="dark"] .header {
        background-color: #1e1e1e;
    }

    .customer-info {
        flex: 1;
    }

    .customer-id {
        font-size: 14px;
        color: var(--gray);
        margin-bottom: 5px;
    }

    .customer-name {
        font-size: 24px;
        font-weight: 600;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .dark-mode .dashboard {
        color: #fff !important;
        border-radius: 10px;
    }

    /* Filter container styles */
    .filter-container {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    body[data-theme="dark"] .filter-container {
        background-color: #1e1e1e;
    }

    .form-select, .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        background-color: white;
        transition: all 0.3s ease;
    }

    body[data-theme="dark"] .form-select, 
    body[data-theme="dark"] .form-control {
        background-color: #252525;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
    }

    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        border-color: var(--primary);
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-secondary {
        background-color: #f0f0f0;
        color: var(--dark);
    }

    body[data-theme="dark"] .btn-secondary {
        background-color: #333;
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    body[data-theme="dark"] .card {
        background-color: #1e1e1e;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 16px;
        color: var(--gray);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .card-value {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .dark-mode .card-value {
        color: #fff !important;
    }

    .card-change {
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .positive {
        color: #2ecc71;
    }

    .negative {
        color: #e74c3c;
    }

    .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        margin-right: 10px;
        color: white;
    }

    .icon-primary {
        background-color: var(--primary);
    }

    .icon-secondary {
        background-color: var(--secondary);
    }

    .icon-success {
        background-color: var(--success);
    }

    .table-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    body[data-theme="dark"] .table-container {
        background-color: #1e1e1e;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 15px 20px;
        text-align: left;
    }

    th {
        background-color: #f8faff;
        font-weight: 600;
        color: var(--gray);
        font-size: 14px;
        transition: all 0.3s ease;
    }

    body[data-theme="dark"] th {
        background-color: #252525;
    }

    tr:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    body[data-theme="dark"] tr:not(:last-child) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .income-type {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
    .dark-mode .income-type {
        color: #fff !important;
        background-color: #808386 !important;
    }

    .income-type i {
        margin-right: 5px;
    }

    .type-salary {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary);
    }

    .type-investment {
        background-color: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }

    .type-freelance {
        background-color: rgba(155, 89, 182, 0.1);
        color: #9b59b6;
    }

    .type-rental {
        background-color: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .amount {
        font-weight: 600;
    }

    .date {
        color: var(--gray);
    }

    /* Animation for icons */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .animated-icon {
        animation: pulse 2s infinite;
        animation-play-state: paused;
    }
    .dark-mode .filter-container{
        background-color: #292525 !important;
        color: #fff !important;
    }
    .dark-mode .btn-secondary{
        background-color: #808386 !important;
        color: #fff !important;
    }
</style>