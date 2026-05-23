<style>
    /* Leaderboard style  */
    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        border-top: 4px solid #e76a35;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #1d3268;
    }

    .profile-title {
        font-size: 14px;
        font-weight: bold;
        color: #e76a35;
        margin-top: 10px;
    }

    .profile-name {
        font-size: 16px;
        font-weight: bold;
        color: #1d3268;
        margin-bottom: 5px;
    }

    .profile-info {
        font-size: 14px;
        color: #1d3268;
        margin: 5px 0;
    }

    .profile-buttons {
        margin-top: 15px;
    }

    .profile-buttons a {
        display: inline-block;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        margin: 5px;
    }

    .btn-view {
        background-color: #1d3268;
        color: white;
    }

    .btn-connect {
        /* background-color: #e76a35; */
        /* color: white; */
    }

    /* Stats Cards Styling */
    /* .stat-card {
        background: linear-gradient(to right, #f8f9fa, #e8eaf6);
        border-radius: 12px;
        padding: 10px;
        max-height: 200px;
        display: flex;
    }

    .stat-icon {
        font-size: 60px;
        color: rgba(108, 117, 125, 0.6);
    } */

    .stat-card {
        background: linear-gradient(to right, #f8f9fa, #e8eaf6);
        border-radius: 12px;
        padding: 10px;
        position: relative;
        /* Enables absolute positioning for the icon */
        overflow: hidden;
        /* Ensures content does not overflow */
    }

    .stat-icon {
        font-size: 60px;
        color: rgba(108, 117, 125, 0.6);
        position: absolute;
        bottom: 10px;
        /* Positions icon at the bottom */
        right: 10px;
        /* Positions icon at the right */
    }




    .text-gradient {
        color: #ab2626;
        font-size: 20px;
    }

    .content {
        margin-right: auto;
    }

    /* Responsive Grid Layout for Leaderboard */
    @media (max-width: 767px) {
        .profile-card {
            margin-bottom: 15px;
        }

        .stat-card {
            margin-bottom: 15px;
        }
    }

    .card-text {
        font-size: 14px;
    }

    .bottom-card {
        height: auto;
        align-self: center;
        margin-bottom: 10px;
    }
</style>

<style>
    body {
        background-color: #f8f9fa;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .section-header a {
        text-decoration: none;
        color: #000;
        font-weight: 500;
    }

    .event-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .event-card:hover {
        transform: scale(1.02);
    }

    .event-img {
        height: 180px;
        object-fit: cover;
        width: 100%;
        border-radius: 10px 10px 0 0;
    }

    .event-details {
        padding: 15px;
    }

    .event-meta {
        font-size: 14px;
        color: #6c757d;
        display: flex;
        align-items: center;
    }

    .event-meta i {
        margin-right: 5px;
    }

    .badge-price {
        background-color: #f8d7da;
        color: #dc3545;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
    }


    .event-card-upcoming {
        background-color: #fafafd;
    }
</style>




{{-- <style>
    .leaderboard .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        /* spacing between cards */
    }

    .leaderboard .profile-card {
        width: 220px;
        height: 486px;
        /* slightly reduced to fit 3 in a row nicely */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        margin: 20px;
        /* changed from centered to spaced for flexbox */
        transition: all 0.3s ease;
    }

    .leaderboard .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .leaderboard .header-image {
        width: 100%;
        height: 60px;
        object-fit: cover;
    }

    .leaderboard .profile-img {
        /* width: 150px;
        height: 150px; */
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -50px;
    }

    .leaderboard h5 {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #1d3268;
    }

    .leaderboard .position {
        color: #1d3268;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .leaderboard .info-section {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .leaderboard .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        flex: 1;
    }

    .leaderboard .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .leaderboard .company-category-section {
        display: flex;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .leaderboard .company-section,
    .leaderboard .category-section {
        flex: 1;
        min-width: 0;
        /* prevents overflow issues */
        text-align: center;
        word-wrap: break-word;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        white-space: normal;
        /* Allows text to wrap */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Limits to 2 lines */
        -webkit-box-orient: vertical;
        word-wrap: break-word;
        line-height: 1.4;
        /* Adjust for better readability */
        max-width: 100%;
    }

    .leaderboard .B-divider {
        width: 1px;
        background-color: #dcdcdc;
        height: 60px;
    }


    .leaderboard .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .leaderboard .logo-section img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        margin: 6px 0;
        color: #1d2951;
        font-size: 16px;
        font-weight: bold;
    }

    .leaderboard .category-section .label {
        color: gray;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .leaderboard .keywords-container {
        text-align: center;
        margin: 15px 20px 10px;
    }

    .leaderboard .keyword-pill {
        display: inline-block;
        background-color: #f3f5fb;
        color: #3a3a3a;
        font-size: 12px;
        padding: 6px 12px;
        margin: 5px 5px;
        border-radius: 20px;
        border: 1px solid #e0e4f0;
        cursor: default;
    }

    .leaderboard .bottom-actions {
        display: flex;
        justify-content: space-between;
        /* Move buttons to corners */
        align-items: center;
        border-top: 1px solid #e6e6e6;
        padding: 10px 0;
        text-align: center;
        width: 100%;

    }

    .leaderboard .action-button {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        color: #1d2951;
        transition: color 0.2s;
        text-decoration: none;
        padding: 10px;
        gap: 8px;
        /* Space between icon and text */
    }

    .leaderboard .action-button.connected {
        color: #e76a35 !important;
        /* Orange color for connected users */
    }


    .leaderboard .action-button i {
        font-size: 16px;
        /* Adjust icon size if needed */
    }

    .leaderboard .divider {
        width: 1px;
        background-color: #e6e6e6;
        height: 100px;
    }


    .leaderboard .bottom-actions div:hover {
        color: #e76a35;
    }

    .leaderboard .bottom-divider {
        width: 1px;
        background-color: #e0e0e0;
        height: 25px;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 1200px) {
        .leaderboard .profile-card {
            width: 280px;
        }
    }

    @media screen and (max-width: 1500px) {
        .leaderboard .profile-card {
            width: 200px;
        }
    }

    @media screen and (max-width: 992px) {
        .leaderboard .profile-card {
            width: 200px;
        }
    }

    @media screen and (max-width: 768px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 10px;
        }
    }

    @media screen and (max-width: 576px) {
        .leaderboard .profile-card {
            width: 100%;
        }
    }

    @media screen and (max-width: 320px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 9px;
        }
    }


    .leaderboard .initials {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #c1c1c1;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        /* mix-blend-mode: color-burn; */

    }
</style> --}}


<style>
    .leaderboard .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        /* spacing between cards */
    }

    .leaderboard .profile-card {
        width: 400px;
        /* slightly reduced to fit 3 in a row nicely */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        margin: 20px;
        /* changed from centered to spaced for flexbox */
        transition: all 0.3s ease;
    }

    .leaderboard .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .leaderboard .header-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .leaderboard .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -50px;
    }

    .leaderboard h5 {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #1d3268;
    }

    .leaderboard .position {
        color: #1d3268;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .leaderboard .info-section {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .leaderboard .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        flex: 1;
    }

    .leaderboard .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .leaderboard .company-category-section {
        display: flex;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .leaderboard .company-section,
    .leaderboard .category-section {
        flex: 1;
        min-width: 0;
        /* prevents overflow issues */
        text-align: center;
        word-wrap: break-word;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        white-space: normal;
        /* Allows text to wrap */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Limits to 2 lines */
        -webkit-box-orient: vertical;
        word-wrap: break-word;
        line-height: 1.4;
        /* Adjust for better readability */
        max-width: 100%;
    }

    .leaderboard .B-divider {
        width: 1px;
        background-color: #dcdcdc;
        height: 60px;
    }


    .leaderboard .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .leaderboard .logo-section img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        margin: 6px 0;
        color: #1d2951;
        font-size: 16px;
        font-weight: bold;
    }

    .leaderboard .category-section .label {
        color: gray;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .leaderboard .keywords-container {
        text-align: center;
        /* margin: 15px 20px 10px; */
    }

    .leaderboard .keyword-pill {
        display: inline-block;
        background-color: #f3f5fb;
        color: #3a3a3a;
        font-size: 12px;
        padding: 6px 12px;
        margin: 5px 5px;
        border-radius: 20px;
        border: 1px solid #e0e4f0;
        cursor: default;
    }

    .leaderboard .bottom-actions {
        display: flex;
        justify-content: space-between;
        /* Move buttons to corners */
        align-items: center;
        border-top: 1px solid #e6e6e6;
        padding: 10px 0;
        text-align: center;
        width: 100%;

    }

    .leaderboard .action-button {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        color: #1d2951;
        transition: color 0.2s;
        text-decoration: none;
        padding: 10px;
        gap: 8px;
        /* Space between icon and text */
    }

    .leaderboard .action-button.connected {
        color: #e76a35 !important;
        /* Orange color for connected users */
    }


    .leaderboard .action-button i {
        font-size: 16px;
        /* Adjust icon size if needed */
    }

    .leaderboard .divider {
        width: 1px;
        background-color: #e6e6e6;
        height: 100px;
    }


    .leaderboard .bottom-actions div:hover {
        color: #e76a35;
    }

    .leaderboard .bottom-divider {
        width: 1px;
        background-color: #e0e0e0;
        height: 25px;
    }

    /* Responsive adjustments */

    @media screen and (max-width: 2560px) {
        .leaderboard .profile-card {
            width: 230px !important;
        }

        .leaderboard .info-section .icon-text {
            font-size: 8px;
        }

        .leaderboard .company-category-section {
            padding: 0%;
            gap: 0%;
        }

        .leaderboard .company-section,
        .leaderboard .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .leaderboard .company-section h2,
        .leaderboard .category-section h3 {
            margin: 0px 0;
            color: #1d2951;
            font-size: 10px;
            font-weight: bold;
        }

        .leaderboard .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .leaderboard .header-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
        }

        .leaderboard .bottom-actions {
            font-size: 12px;
        }

        .leaderboard .btn-connect {
            font-size: 12px;
            color: #1d3268;
        }

        .leaderboard .position {
            font-size: 8px;
        }

        .leaderboard .member-name {
            font-size: 12px;
        }
    }


    @media screen and (max-width: 1440px) {
        .leaderboard .profile-card {
            width: 195px !important;
        }

        .leaderboard .info-section .icon-text {
            font-size: 12px;
        }

        .leaderboard .company-category-section {
            padding: 0%;
            gap: 0%;
        }

        .leaderboard .company-section,
        .leaderboard .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .leaderboard .company-section h2,
        .leaderboard .category-section h3 {
            margin: 0px 0;
            color: #1d2951;
            font-size: 12px;
            font-weight: bold;
        }

        .leaderboard .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .leaderboard .header-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
        }

        .leaderboard .bottom-actions {
            font-size: 12px;
        }

        .leaderboard .btn-connect {
            font-size: 12px;
        }

        .leaderboard .position {
            font-size: 12px;
        }

        .leaderboard .member-name {
            font-size: 15px;
        }


    }

    @media screen and (max-width: 1024px) {
        .leaderboard .profile-card {
            width: 195px !important;
        }

        .leaderboard .info-section .icon-text {
            font-size: 12px;
        }

        .leaderboard .company-category-section {
            padding: 0%;
            gap: 0%;
        }

        .leaderboard .company-section,
        .leaderboard .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .leaderboard .company-section h2,
        .leaderboard .category-section h3 {
            margin: 0px 0;
            color: #1d2951;
            font-size: 12px;
            font-weight: bold;
        }

        .leaderboard .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .leaderboard .header-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
        }

        .leaderboard .bottom-actions {
            font-size: 12px;
        }

        .leaderboard .btn-connect {
            font-size: 12px;
        }

        .leaderboard .position {
            font-size: 12px;
        }

        .leaderboard .member-name {
            font-size: 15px;
        }


    }

    @media screen and (max-width: 992px) {
        .leaderboard .profile-card {
            width: 210px;
        }


    }

    @media screen and (max-width: 1500px) {
        .leaderboard .profile-card {
            width: 200px;
        }


    }

    @media screen and (max-width: 768px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 10px;
        }
    }

    @media screen and (max-width: 576px) {
        .leaderboard .profile-card {
            width: 100%;
        }
    }

    @media screen and (max-width: 320px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 9px;
        }
    }


    .leaderboard .initials {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #c1c1c1;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        /* mix-blend-mode: color-burn; */

    }

    .leaderboard .heading {
        color: #1d3268;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .leaderboard .col-lg-4 {
        width: 31.33333333% !important;
    }
</style>


{{-- upcoming events css start --}}

{{-- <style>
    .upcoming-events {
        max-width: 1100px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Horizontal Scroll */
    .upcoming-events .events-container {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
    }

    .upcoming-events .events-container::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar */
    }

    .upcoming-events .event-card {
        min-width: 300px;
        max-width: 320px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        background: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .upcoming-events .event-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .upcoming-events .event-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        padding: 10px;
        color: white;
    }

    .upcoming-events .event-details {
        padding: 12px;
    }

    .upcoming-events .price-tag {
        background: #ffe0e0;
        color: #d9534f;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
    }
</style> --}}

<style>
    .upcoming-events {
        max-width: 1100px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Horizontal Scroll */
    .upcoming-events .events-container {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
    }

    .upcoming-events .events-container::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar */
    }

    .upcoming-events .event-card {
        min-width: 300px;
        max-width: 320px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        background: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .upcoming-events .event-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Overlay for Text */
    .upcoming-events .event-info {
        position: relative;
        bottom: 0;
        left: 0;
        width: 100%;
        /* background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent); */
        padding: 10px;
        color: #1d3268;
    }

    .upcoming-events .event-info h6 {
        margin-bottom: 5px;
        font-size: 15px;
        font-weight: 600;
    }

    .upcoming-events .event-info small {
        font-size: 12px;
        display: block;
        opacity: 0.9;
    }

    /* Event Details Below */
    .upcoming-events .event-details {
        padding: 12px;
    }

    .upcoming-events .price-tag {
        background: #ffe0e0;
        color: #d9534f;
        padding: 5px 10px;
        border-radius: 30px;
        font-weight: 600;
    }

    .card-title {
        padding: 0% !important;
        font-size:
    }
</style>


{{-- php code for get city count start --}}

@php
    use App\Models\Member;
    use App\Models\Circle;
    use Illuminate\Support\Facades\DB;

    // Get distinct city IDs from active members
    $memberCities = Member::where('status', 'Active')->whereNotNull('cityId')->distinct()->pluck('cityId')->toArray();

    // Get distinct city IDs from circles
    $circleCities = Circle::whereNotNull('cityId')->distinct()->pluck('cityId')->toArray();

    // Combine both lists and remove duplicates
    $allCities = array_unique(array_merge($memberCities, $circleCities));

    // Final total unique count
    $cityCount = count($allCities);
    // dd($allCities);
@endphp

{{-- php code for get city count end --}}

@role('Digital Member')
    @php
        $authUser = auth()->user();

        $totalBusinessAmount = \App\Models\CircleMeetingMembersBusiness::where('status', 'Active')->sum('amount');

        $totalReferences = \App\Models\CircleMeetingMembersReference::where('status', 'Active')->count();

        $totalIbms = \App\Models\CircleCall::where('status', 'Active')->count();

        $receivedRequests = \App\Models\Connection::whereHas('member', function ($query) use ($authUser) {
            $query->where('memberId', $authUser->id);
        })
            ->with('member')
            ->where('recordStatus', 'Active')
            ->where('status', 'Pending')
            ->paginate(4);
        // $latestMembers = Member::with('circle')->where('status', 'Active')->orderBy('created_at', 'desc')->take(4)->get();

        // $posts = \App\Models\Post::with(['user.member', 'media'])
        //     ->withCount(['likes', 'comments'])
        //     ->latest()
        //     ->take(4)
        //     ->get();
        $posts = \App\Models\Post::with(['user.member', 'media'])
            ->whereNotNull('attachment')
            ->where('attachment', '!=', '')
            ->with(['user.member', 'media'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(4)
            ->get();
        $member = Member::where('userId', Auth::id())->first();

        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');

        $nearestTraining = \App\Models\Training::where('status', 'Active')->where('trainingStatus', 'Publish')->whereDate('date', '>', $currentDate)->orderBy('date', 'asc')->whereHas('trainers.user')->with('trainers.user')->whereHas('trainersTrainings.user')->get() ?? collect();

        $nearestEvents = \App\Models\Event::where('eventStatus', 'Publish')->where('status', 'Active')->whereDate('event_date', '>=', $currentDate)->orderBy('event_date', 'asc')->get();

        $latestDigitalMembers = Member::with('circle')->where('status', 'Active')->where('membershipType', 'Digital Membership')->orderBy('created_at', 'desc')->take(4)->get();
    @endphp

    <div class="modal fade" id="updateProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content border-0 shadow-lg" style="border-radius:20px; overflow:hidden;">

                <div style="height:5px; background:linear-gradient(90deg,#1d3268,#4f8cff);"></div>

                {{-- Header --}}
                <div class="modal-header border-0 pb-0 pt-3 px-4">
                    <h5 class="fw-bold" style="color:#1d3268;font-size:17px;">
                        Complete your profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body px-4 pb-4 pt-3" style="color:#333;font-size:15px;font-family:sans-serif;">

                    <form method="POST" action="{{ route('member.update', $member->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $member->id }}">

                        {{-- ================= PERSONAL ================= --}}
                        @php
                            $missingFields = [];
                            $personalFields = ['Title', 'First Name', 'Last Name', 'Gender', 'Birth Date'];
                            $personal = collect($missingFields)->filter(fn($f) => in_array($f, $personalFields));
                            $col = $personal->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($personal->isNotEmpty())
                            <p class="section-label">Personal</p>
                            <div class="row g-3">

                                @if (in_array('Title', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Title</label>
                                        <select name="title" class="form-control custom-input">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('First Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">First Name</label>
                                        <input type="text" name="firstName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Last Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Last Name</label>
                                        <input type="text" name="lastName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Gender', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Gender</label>
                                        <select name="gender" class="form-control custom-input">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('Birth Date', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Birth Date</label>
                                        <input type="date" name="birthDate" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= KEYWORDS ================= --}}
                        @if (in_array('Keywords', $missingFields))
                            <p class="section-label mt-3">Keywords</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="field-label">Keyword 1</label>
                                    <input type="text" name="keyword1" class="form-control custom-input">
                                </div>

                                <div class="col-12">
                                    <label class="field-label">Keyword 2</label>
                                    <input type="text" name="keyword2" class="form-control custom-input">
                                </div>

                                <div class="col-12">
                                    <label class="field-label">Keyword 3</label>
                                    <input type="text" name="keyword3" class="form-control custom-input">
                                </div>
                            </div>
                        @endif


                        {{-- ================= CONTACT ================= --}}
                        @php
                            $contactFields = ['Email', 'Contact Number', 'Address Line 1', 'Address Line 2', 'City', 'Landmark'];
                            $contact = collect($missingFields)->filter(fn($f) => in_array($f, $contactFields));
                            $col = $contact->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($contact->isNotEmpty())
                            <p class="section-label mt-3">Contact</p>
                            <div class="row g-3">

                                @if (in_array('Email', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Contact Number', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Contact Number</label>
                                        <input type="text" name="contactNo" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Address Line 1', $missingFields))
                                    <div class="col-12">
                                        <label>Address Line 1</label>
                                        <input type="text" name="addressLine1" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Address Line 2', $missingFields))
                                    <div class="col-12">
                                        <label>Address Line 2</label>
                                        <input type="text" name="addressLine2" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('City', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>City</label>
                                        <select name="city" class="form-control custom-input">
                                            <option value="">Select City</option>
                                            @foreach ($city as $cities)
                                                <option value="{{ $cities->id }}">{{ $cities->cityName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('Landmark', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Landmark</label>
                                        <select name="landmark" id="modalLandmark" class="form-control custom-input">
                                            <option value="">Select Landmark</option>
                                            @foreach ($landmarks as $lm)
                                                <option value="{{ $lm }}">{{ $lm }}</option>
                                            @endforeach
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-2" id="modalOtherLandmark" style="display:none;">
                                        <input type="text" name="other_landmark" class="form-control" placeholder="Enter Landmark">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= BUSINESS ================= --}}
                        @php
                            $businessFields = ['Company Name', 'Website', 'GST/PAN'];
                            $business = collect($missingFields)->filter(fn($f) => in_array($f, $businessFields));
                            $col = $business->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($business->isNotEmpty())
                            <p class="section-label mt-3">Business</p>
                            <div class="row g-3">

                                @if (in_array('Company Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Company Name</label>
                                        <input type="text" name="companyName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('GST/PAN', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>GST / PAN</label>
                                        <input type="text" name="gstinPan" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Website', $missingFields))
                                    <div class="col-12">
                                        <label>Website</label>
                                        <input type="text" name="webSite" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= UPLOAD ================= --}}
                        @php
                            $uploadFields = ['Profile Photo', 'Company Logo'];
                            $upload = collect($missingFields)->filter(fn($f) => in_array($f, $uploadFields));
                            $col = $upload->count() == 1 ? 'col-12' : 'col-6';

                        @endphp

                        @if ($upload->isNotEmpty())
                            <p class="section-label mt-3">Uploads</p>
                            <div class="row g-3">

                                @if (in_array('Profile Photo', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Profile Photo</label>
                                        <input type="file" name="profilePhoto" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Company Logo', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Company Logo</label>
                                        <input type="file" name="companyLogo" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-later" data-bs-dismiss="modal">Later</button>
                            <button type="submit" class="btn btn-save">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($missingFields) > 0 && !session('profileUpdated'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
                myModal.show();
            });
        </script>
    @endif

    <style>
        .section-label {
            font-size: 11px;
            font-weight: 700;
            color: #1d3268;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 0 0 12px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #6c7a9c;
            margin-bottom: 5px;
            letter-spacing: 0.3px;
        }

        .custom-input {
            border-radius: 12px;
            padding: 9px 13px;
            border: 1px solid #e3e7f1;
            font-size: 13px;
            color: #1d3268;
            transition: border-color .2s, box-shadow .2s;
            background: #fff;
        }

        .custom-input:focus {
            border-color: #4f8cff;
            box-shadow: 0 0 0 3px rgba(79, 140, 255, .12);
            outline: none;
        }

        .custom-input::placeholder {
            color: #adb5cc;
        }

        .upload-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: 1.5px dashed #c8d1e8;
            border-radius: 12px;
            padding: 14px 8px;
            cursor: pointer;
            background: #fafbfd;
            transition: border-color .2s, background .2s;
        }

        .upload-box:hover {
            border-color: #4f8cff;
            background: #f0f5ff;
        }

        .upload-box span {
            font-size: 11px;
            color: #6c7a9c;
        }

        .btn-later {
            padding: 10px 20px;
            border-radius: 12px;
            border: 1px solid #e3e7f1;
            background: #f4f6fb;
            color: #6c7a9c;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-later:hover {
            background: #e3e7f1;
            color: #1d3268;
        }

        .btn-save {
            padding: 10px 28px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #1d3268, #4f8cff);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            transition: opacity .2s, transform .15s;
        }

        .btn-save:hover {
            opacity: .92;
            transform: translateY(-1px);
            color: #fff;
        }
    </style>
    <style>
        .compact-stats .stat-card {
            padding: 8px;
            border-radius: 10px;
        }

        .compact-stats .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ab2626;
            line-height: 1.2;
        }

        .compact-stats .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-top: 2px;
        }

        .compact-stats .stat-icon {
            position: static !important;
            font-size: 1.75rem;
            color: rgba(108, 117, 125, 0.6);
        }
    </style>
    <div class="row compact-stats">
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 stat-card">
                <div class="d-flex align-items-center justify-content-between p-2">
                    <div>
                        <div class="stat-value">₹ {{ number_format($totalBusinessAmount ?? 0, 0) }}</div>
                        <div class="stat-label">Total Business</div>
                    </div>
                    <i class="bi bi-cash-stack stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 ">
            <div class="card shadow-sm border-0 stat-card">
                <div class="d-flex align-items-center justify-content-between p-2">
                    <div>
                        <div class="stat-value">{{ $totalReferences }}</div>
                        <div class="stat-label">Total Referrals</div>
                    </div>
                    <i class="bi bi-person-rolodex stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 stat-card">
                <div class="d-flex align-items-center justify-content-between p-2">
                    <div>
                        <div class="stat-value">{{ $totalIbms }}</div>
                        <div class="stat-label">Total IBMs</div>
                    </div>
                    <i class="bi bi-calendar-event stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Cities Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="content p-3">
                            <h2 class="fw-bold text-gradient">{{ $cityCount }}</h2>
                            <p class="text-uppercase text-muted fw-semibold">Cities</p>
                        </div>
                    </div>
                </div>
                <!-- Icon positioned at the bottom right, overlapping slightly -->
                <i class="bi bi-buildings stat-icon position-absolute" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
            </div>
        </div>

        <!-- Circles Card -->
        {{-- <div class="col-md-4">
        <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="content p-3">
                        <h2 class="fw-bold text-gradient">{{ $circleCount }}</h2>
                        <p class="text-uppercase text-muted fw-semibold">Circles</p>
                    </div>
                </div>
            </div>
            <i class="bi bi-bullseye stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
        </div>
    </div> --}}

        <!-- Members Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                <div class="row">
                    <div class="col-md-7">
                        <div class="content p-3">
                            <h2 class="fw-bold text-gradient">{{ $membersCount }}</h2>
                            <p class="text-uppercase text-muted fw-semibold">Members Across UBN</p>
                        </div>
                    </div>
                </div>
                <i class="bi bi-people stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
            </div>
        </div>
    </div>
    {{-- <style>
        .uplfeed-card {
            background: #f2f2f2;

            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 505px; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-only-card {
            padding: 0;
        }

        .uplfeed-img-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .uplfeed-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }
    </style>
    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        🏏 UBN Primer League 2.0 Sponsers
                    </h5>
                </div>
            </div>

            <div class="card-body p-3">

                <!-- ✅ ONLY 2 CARDS -->
                <div class="row row-cols-1 row-cols-md-2 g-4">

                    <!-- ✅ CARD 1 → Title Sponsor -->
                    <div class="col">
                        <div class="uplfeed-card image-only-card">
                            <div class="uplfeed-img-section">
                                <div class="uplfeed-img-wrapper">
                                    <!-- 🔥 Replace with your actual image name -->
                                    <img src="uplcricket_images/title_sponser.jpeg" class="uplfeed-img" alt="Title Sponsor">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ CARD 2 → Co Sponsor -->
                    <div class="col">
                        <div class="uplfeed-card image-only-card">
                            <div class="uplfeed-img-section">
                                <div class="uplfeed-img-wrapper">
                                    <!-- 🔥 Replace with your actual image name -->
                                    <img src="uplcricket_images/co_sponser.jpeg" class="uplfeed-img" alt="Co Sponsor">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <style>
        .captianfeed-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 220px; */
            transition: 0.3s;
        }

        .captianfeed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .image-only-card {
            padding: 0;
        }

        .captianfeed-img-section,
        .captianfeed-img-wrapper {
            width: 100%;
            height: 100%;
        }

        .captianfeed-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 🔥 IMPORTANT FIX */
            display: block;
        }
    </style>

    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <h5 class="fw-bold mb-0">🏏 UBN Primer League 2.0 Team & Captains</h5>
            </div>

            <div class="card-body p-3">

                <!-- ✅ 6 CARDS GRID -->
                <div class="row row-cols-2 row-cols-md-3 g-4">

                    <!-- TEAM 1 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team1.jpeg') }}" class="captianfeed-img" alt="Team 1 Captain">
                        </div>
                    </div>

                    <!-- TEAM 2 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team2.jpeg') }}" class="captianfeed-img" alt="Team 2 Captain">
                        </div>
                    </div>

                    <!-- TEAM 3 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team3.jpeg') }}" class="captianfeed-img" alt="Team 3 Captain">
                        </div>
                    </div>

                    <!-- TEAM 4 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team4.jpeg') }}" class="captianfeed-img" alt="Team 4 Captain">
                        </div>
                    </div>

                    <!-- TEAM 5 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team5.jpeg') }}" class="captianfeed-img" alt="Team 5 Captain">
                        </div>
                    </div>

                    <!-- TEAM 6 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team6.jpeg') }}" class="captianfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endif
    <style>
        .sponsorfeed-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 220px; */
            transition: 0.3s;
        }

        .sponsorfeed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .image-only-card {
            padding: 0;
        }

        .sponsorfeed-img-section,
        .sponsorfeed-img-wrapper {
            width: 100%;
            height: 100%;
        }

        .sponsorfeed-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 🔥 IMPORTANT FIX */
            display: block;
        }
    </style>

    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <h5 class="fw-bold mb-0">🏏 UBN Primer League 2.0 Tournament Essentials Suponsors</h5>
            </div>

            <div class="card-body p-3">

                <!-- ✅ 6 CARDS GRID -->
                <div class="row row-cols-1 row-cols-md-5 g-4">

                    <!-- TEAM 1 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/anchor_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 1 Captain">
                        </div>
                    </div>

                    <!-- TEAM 2 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/bat_ball_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 2 Captain">
                        </div>
                    </div>

                    <!-- TEAM 3 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/six_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 3 Captain">
                        </div>
                    </div>

                    <!-- TEAM 4 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/four_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 4 Captain">
                        </div>
                    </div>

                    <!-- TEAM 5 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/noball_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 5 Captain">
                        </div>
                    </div>

                    <!-- TEAM 6 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/sound_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/umpire_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/water_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/wicket_sopnsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/wide_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endif --}}
    <style>
        .fb-card {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            height: 100%;
            display: flex;
            flex-direction: column;
            font-family: sans-serif;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .fb-card-img-wrapper {
            width: 100%;
            padding-top: 100%;
            /* 1:1 Aspect Ratio */
            position: relative;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .fb-card-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fb-card-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .fb-card-title {
            color: #1d3268;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .fb-card-subtitle {
            color: #65676b;
            font-size: 15px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .fb-card-info {
            color: #65676b;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .fb-card-info i {
            color: #e76a35;
        }

        .fb-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e76a35;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .fb-btn {
            width: 100%;
            border: none;
            border-radius: 6px;
            padding: 8px 0;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .fb-btn:hover {
            text-decoration: none;
        }

        .fb-btn-primary {
            background-color: #1d3268;
            color: #fff;
        }

        .fb-btn-primary:hover {
            background-color: #15244d;
            color: #fff;
        }

        .fb-btn-secondary {
            background-color: #e4e6eb;
            color: #1d3268;
            margin-top: 10px;
        }

        .fb-btn-secondary:hover {
            background-color: #d8dadf;
            color: #1d3268;
        }

        .fb-btn-disabled {
            background-color: #e4e6eb;
            color: #bcc0c4;
            cursor: default;
        }

        .view-more-btn {
            display: inline-block;
            padding: 8px 12px;
            border: 2px solid #fff;
            border-radius: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            /* letter-spacing: 0.5px; */
            transition: all 0.3s ease;
        }

        .view-more-btn span {
            margin-left: 6px;
        }

        .view-more-btn:hover {
            background-color: #fff;
            color: #1d3268;
        }
    </style>
    @if ($receivedRequests && $receivedRequests->count() > 0)
        <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Card Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people-fill me-2"></i>Connection Requests
                    </h5>
                    @if ($posts->count() >= 4)
                        <a href="{{ route('connection.myConnections') }}" class="text-white custom-underline">
                            View All <span>»</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @forelse ($receivedRequests as $member)
                        <div class="col">
                            <div class="fb-card shadow-sm h-100">

                                <div class="fb-card-img-wrapper">
                                    <span class="fb-badge">Member</span>
                                    <img src="{{ asset('ProfilePhoto/' . ($member->receiver->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                                </div>

                                <div class="fb-card-body">

                                    <h5 class="fb-card-title">
                                        {{ $member->user->firstName ?? 'N/A' }}
                                        {{ $member->user->lastName ?? 'N/A' }}
                                    </h5>

                                    {{-- <div class="fb-card-subtitle">
                                        <i class="bi bi-geo-alt-fill"></i> N/A
                                    </div> --}}

                                    {{-- <div class="fb-card-info">
                                        <div><i class="bi bi-envelope-fill"></i> *****</div>
                                        <div><i class="bi bi-telephone-fill"></i> *****</div>
                                    </div> --}}

                                    @if (!empty($member->members->companyName) || !empty($member->members->bCategory->categoryName))
                                        <div class="fb-card-info">

                                            @if (!empty($member->members->companyName))
                                                <div>
                                                    <i class="bi bi-building"></i>
                                                    {{ $member->members->companyName }}
                                                </div>
                                            @endif

                                            @if (!empty($member->members->bCategory->categoryName))
                                                <div>
                                                    <i class="bi bi-tag"></i>
                                                    {{ $member->members->bCategory->categoryName }}
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    <div class="mt-auto">

                                        <a href="{{ route('foundPersonDetails', $member->members->id) }}" class="fb-btn fb-btn-primary w-100 text-decoration-none">
                                            View Profile
                                        </a>

                                        <div class="mt-2 text-center fw-bold" style="color:#1d3268;">
                                            Inductions -
                                            {{ $member->members->sponsored_count ?? $member->members->sponsored->count() }}
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <a href="{{ route('connection.reject', $member->id) }}" class="fb-btn fb-btn-secondary flex-fill">
                                                <i class="bi bi-x-circle me-2"></i> Reject
                                            </a>

                                            <a href="{{ route('connection.accept', $member->id) }}" class="fb-btn fb-btn-secondary flex-fill">
                                                <i class="bi bi-check-circle me-2"></i> Accept
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    @empty
                        <p class="text-center text-muted">No Connection Requests</p>
                    @endforelse
                </div>

            </div>
        </div>
    @endif
    @if ($latestDigitalMembers && $latestDigitalMembers->count() > 0)
        <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Card Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people-fill me-2"></i>New Members Sportlights
                    </h5>
                    {{-- @if ($posts->count() >= 4)
                        <a href="{{ route('connection.myConnections') }}" class="view-more-btn">
                            View All <span>»</span>
                        </a>
                    @endif --}}
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @forelse ($latestDigitalMembers->take(4) as $member)
                        <div class="col">
                            <div class="fb-card shadow-sm h-100">

                                <div class="fb-card-img-wrapper">
                                    <span class="fb-badge">Member</span>
                                    <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                                </div>

                                <div class="fb-card-body">

                                    <h5 class="fb-card-title">
                                        {{ $member->user->firstName ?? 'N/A' }}
                                        {{ $member->user->lastName ?? 'N/A' }}
                                    </h5>

                                    <div class="fb-card-subtitle">
                                        <i class="bi bi-people-fill"></i>
                                        {{ $member->circle->circleName ?? 'N/A' }}
                                    </div>


                                    {{-- <div class="fb-card-info">
                                        <div><i class="bi bi-envelope-fill"></i> *****</div>
                                        <div><i class="bi bi-telephone-fill"></i> *****</div>
                                    </div> --}}

                                    @if (!empty($member->companyName) || !empty($member->bCategory->categoryName))
                                        <div class="fb-card-info">

                                            @if (!empty($member->companyName))
                                                <div>
                                                    <i class="bi bi-building"></i>
                                                    {{ $member->companyName }}
                                                </div>
                                            @endif

                                            @if (!empty($member->bCategory->categoryName))
                                                <div>
                                                    <i class="bi bi-tag"></i>
                                                    {{ $member->bCategory->categoryName }}
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <!-- Connect Button -->
                                        @php
                                            $connectionStatus = $member->connection_status ?? 'Not Connected';
                                        @endphp
                                        @if ($connectionStatus == 'Connected')
                                            <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                        @elseif ($connectionStatus == 'Accepted')
                                            <button class="fb-btn fb-btn-primary">Message</button>
                                        @elseif ($connectionStatus == 'Pending')
                                            <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                        @else
                                            <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                                @csrf
                                                <input type="hidden" value="{{ $member->id }}" name="memberId">
                                                <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                            </form>
                                        @endif

                                        <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                            Inductions - {{ $member->sponsored->count() }}
                                        </div>

                                        <!-- View Profile -->
                                        <a href="{{ route('foundPersonDetails', $member->id) }}" class="text-decoration-none d-block w-100">
                                            <button class="fb-btn fb-btn-secondary">View Profile</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No New Members</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    <style>
        .feed-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            height: 320px;
            min-width: 250px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .feed-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
        }

        .feed-img-section {
            flex: 1;
            position: relative;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            /* fixed height for uniform cards */
            overflow: hidden;
        }

        .feed-img-section-full {
            flex: 1;
            /* <-- this is the key fix */
            display: flex;
            flex-direction: column;
        }


        .feed-img-wrapper {
            width: 100%;
            padding-top: 75%;
            /* Fixed aspect ratio, smaller for better fit */
            position: relative;
            background: #f8f9fa;
        }

        .feed-img-section-full .feed-img-wrapper {
            flex: 1;
            padding-top: 0;
            /* remove the aspect-ratio padding trick */
            position: relative;
            min-height: 180px;
            /* ensure a minimum visible height */
        }

        .feed-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contant;
            /* Ensures full image coverage without empty space */
            display: block
        }

        .feed-user {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .feed-user img {
            width: 40px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }

        .feed-name {
            font-size: 15px;
            font-weight: 700;
            color: #1d3268;
        }

        .feed-time {
            font-size: 12px;
            color: #777;
        }

        .feed-body-no-caption {
            padding: 10px 14px;
        }

        .feed-caption {
            font-size: 14px;
            color: #333;
            margin-top: 6px;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* 👈 Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .feed-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e76a35;
            color: white;
            padding: 4px 10px;
            font-size: 12px;
            border-radius: 4px;
        }

        .view-more-btn {
            display: inline-block;
            padding: 8px 20px;
            border: 2px solid #fff;
            border-radius: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .view-more-btn span {
            margin-left: 6px;
        }

        .view-more-btn:hover {
            background-color: #fff;
            color: #1d3268;
        }
    </style>


    <div class="card shadow-sm  mt-3"style="border-radius: 12px; overflow: hidden;">

        <div class="card-header text-white" style="background:#1d3268;">
            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-newspaper me-2"></i>Network Feed
                </h5>

                @if ($posts->count() >= 4)
                    <a href="{{ route('social-wall.index') }}" class="view-more-btn">
                        VIEW All <span>»»</span>
                    </a>
                @endif

            </div>
        </div>

        <div class="card-body p-3">

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                @foreach ($posts as $post)
                    @php
                        $member = optional($post->user->member);
                        $profile = $member->profilePhoto ?? 'profile.png';

                        $postImage = null;
                        if ($post->media && $post->media->count() > 0) {
                            $postImage = asset($post->media->first()->file_path);
                        }
                    @endphp

                    <div class="col">
                        <div class="feed-card">

                            {{-- Only show the header section if there's a caption --}}
                            @if ($post->caption)
                                <div class="feed-body">
                                    <div class="feed-user">
                                        <img src="{{ asset('ProfilePhoto/' . $profile) }}">
                                        <div>
                                            <div class="feed-name">
                                                {{ $post->user->firstName }} {{ $post->user->lastName }}
                                            </div>
                                            <div class="feed-time">
                                                {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="feed-caption">
                                        {{ $post->caption }}
                                    </div>
                                </div>
                            @else
                                {{-- No caption: show user info overlaid on image or just minimal top strip --}}
                                <div class="feed-body feed-body-no-caption">
                                    <div class="feed-user mb-0">
                                        <img src="{{ asset('ProfilePhoto/' . $profile) }}">
                                        <div>
                                            <div class="feed-name">
                                                {{ $post->user->firstName }} {{ $post->user->lastName }}
                                            </div>
                                            <div class="feed-time">
                                                {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($postImage)
                                <div class="feed-img-section {{ !$post->caption ? 'feed-img-section-full' : '' }}">
                                    <div class="feed-img-wrapper">
                                        <img src="{{ $postImage }}" class="feed-img" alt="Post image">
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if ($nearestTraining && $nearestTraining->count())
        <div class="bg-light py-5">
            <div class="upcoming-events trainings">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Training Workshops</h4>
                    <a href="#" class="fw-bold text-decoration-none" style="color: #1d3268;">See All</a>
                </div>

                <!-- Horizontal Scrollable Cards -->
                <div class="events-container d-flex">
                    @foreach ($nearestTraining as $trainings)
                        <div class="event-card">
                            {{-- <a href="{{ route('events.details', $trainings->id) }}" class="text-decoration-none">
                                --}}
                            <img src="{{ $trainings->training_banner ? url('Training/' . $trainings->training_banner) : asset('images/profile.png') }}" alt="{{ $trainings->title }}">

                            <!-- Event Info Overlay -->
                            <div class="event-info">
                                <h6 class="fw-bold">{{ $trainings->title }}</h6>
                                <small class="fw-bold">📍 {{ $trainings->venue }}</small>
                                {{-- <small>📍 {{ $trainings->venue }}, {{ $trainings->location }}</small> --}}
                            </div>

                            <!-- Event Details -->
                            <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                                <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($trainings->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($trainings->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($trainings->end_time)->format('H:i') }}</span>
                                {{-- <span>⏳ Time {{ $trainings->duration }}</span> --}}
                                <span class="price-tag fw-bold">₹ {{ $trainings->fees }}</span>
                            </div>
                            {{-- </a> --}}
                        </div>

                        <!-- Event Details -->
                        <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                            <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($trainings->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($trainings->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($trainings->end_time)->format('H:i') }}</span>
                            {{-- <span>⏳ Time {{ $trainings->duration }}</span> --}}
                            <span class="price-tag fw-bold">₹ {{ $trainings->fees }}</span>
                        </div>
                        {{-- </a> --}}
                </div>
    @endforeach
    </div>
    </div>
    </div>
@else
    <style>
        .upcoming-events .trainings {
            display: none;
        }
    </style>
    {{-- <div class="bg-light py-5">
            <div class="upcoming-events trainings">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Training Workshops</h4>
                </div>
                <p class="text-muted text-center"><b>No Training Workshops for now.</b></p>
            </div>
        </div> --}}
    @endif
    @if ($nearestEvents && $nearestEvents->count())
        <div class="bg-light py-5">
            <div class="upcoming-events">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Events</h4>
                    <a href="#" class="fw-bold text-decoration-none" style="color: #1d3268;">See All</a>
                </div>

                <!-- Horizontal Scrollable Cards -->
                <div class="events-container d-flex">
                    @foreach ($nearestEvents as $event)
                        <div class="event-card">
                            <a href="{{ route('events.details', $event->id) }}" class="text-decoration-none">
                                <img src="{{ $event->event_banner ? url('Event/' . $event->event_banner) : asset('images/event_default.png') }}" alt="{{ $event->title }}">

                                <!-- Event Info Overlay -->
                                <div class="event-info">
                                    <h6 class="fw-bold">{{ $event->title }}</h6>
                                    <small class="fw-bold">📍 {{ $event->venue }}</small>
                                    {{-- <small>📍 {{ $event->venue }}, {{ $event->location }}</small> --}}
                                </div>

                                <!-- Event Details -->
                                <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                                    <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                                    {{-- <span>⏳ Time {{ $event->duration }}</span> --}}
                                    <span class="price-tag fw-bold">₹ {{ $event->fees }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <style>
            .upcoming-events {
                display: none;
            }
        </style>
        {{-- <div class="bg-light py-5">
                <div class="upcoming-events">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold" style="color: #1d3268;">Upcoming Events</h4>
                    </div>
                    <p class="text-muted text-center"><b>No Events for now.</b></p>
                </div>
            </div> --}}
    @endif
@endrole

{{-- upcoming events css end --}}

@role('Member')

    @php
        $totalBusinessAmount = \App\Models\CircleMeetingMembersBusiness::where('status', 'Active')->sum('amount');
        $totalReferences = \App\Models\CircleMeetingMembersReference::where('status', 'Active')->count();
        $totalIbms = \App\Models\CircleCall::where('status', 'Active')->count();

        // $posts = \App\Models\Post::with(['user.member', 'media'])
        //     ->withCount(['likes', 'comments'])
        //     ->where('status', 'Active')
        //     ->whereHas('user', function ($query) {
        //         $query->where('status', 'Active');
        //     })
        //     ->latest()
        //     ->take(4)
        //     ->get();
        $posts = \App\Models\Post::with(['user.member', 'media'])
            ->whereNotNull('attachment')
            ->where('attachment', '!=', '')
            ->with(['user.member', 'media'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(4)
            ->get();
        // $latestMembers = Member::with('circle')->where('status', 'Active')->orderBy('created_at', 'desc')->take(4)->get();
    @endphp
    <!-- Change Password Modal -->
    @if ($showChangePasswordModal)
        <div id="changePasswordPopup" style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
">

            <div style="
        width: 650px;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        animation: popupFade 0.3s ease-in-out;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    ">

                <!-- Header -->
                <div style="
            background:#1d3268;
            color:white;
            padding:18px 20px;
        ">
                    <h4 style="
                margin:0;
                font-size:20px;
                font-weight:600;
            ">
                        Change Password
                    </h4>
                </div>

                <!-- Body -->
                <div style="padding:25px;">

                    <div style="
                background:#fff3cd;
                color:#856404;
                border:1px solid #ffeeba;
                padding:12px;
                border-radius:8px;
                margin-bottom:20px;
                font-size:14px;
            ">
                        Your account is using a default password.
                        Please change your password before continuing.
                    </div>

                    <form action="{{ route('force.change.password') }}" method="POST" onsubmit="return validatePasswordForm()">

                        @csrf

                        <!-- Error Box -->
                        <div id="passwordError" style="
        display:none;
        background:#f8d7da;
        color:#842029;
        border:1px solid #f5c2c7;
        padding:12px;
        border-radius:8px;
        margin-bottom:18px;
        font-size:14px;
    ">
                        </div>

                        <!-- New Password -->
                        <div style="margin-bottom:18px;">

                            <label style="
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#333;
        ">
                                New Password
                            </label>

                            <input type="password" name="password" id="newPassword" required class="form-control" style="
                    height:45px;
                    border-radius:8px;
               ">
                        </div>

                        <!-- Confirm Password -->
                        <div style="margin-bottom:25px;">

                            <label style="
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#333;
        ">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" id="confirmPassword" required class="form-control" style="
                    height:45px;
                    border-radius:8px;
               ">
                        </div>

                        <!-- Button -->
                        <button type="submit" style="
                width:100%;
                background:#1d3268;
                color:white;
                border:none;
                height:48px;
                border-radius:8px;
                font-size:16px;
                font-weight:600;
                cursor:pointer;
                transition:0.3s;
            " onmouseover="this.style.background='#162750'" onmouseout="this.style.background='#1d3268'">

                            Update Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <style>
            @keyframes popupFade {

                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>
        <script>
            function validatePasswordForm() {
                let password = document.getElementById('newPassword').value;
                let confirmPassword = document.getElementById('confirmPassword').value;

                let errorBox = document.getElementById('passwordError');

                errorBox.style.display = 'none';
                errorBox.innerHTML = '';

                // Prevent default password
                if (password === '123456') {

                    errorBox.style.display = 'block';
                    errorBox.innerHTML =
                        '123456 password is not allowed. Please use a secure password.';

                    return false;
                }

                // Minimum 6 chars
                if (password.length < 6) {

                    errorBox.style.display = 'block';
                    errorBox.innerHTML =
                        'Password must be at least 6 characters.';

                    return false;
                }

                // Password mismatch
                if (password !== confirmPassword) {

                    errorBox.style.display = 'block';
                    errorBox.innerHTML =
                        'Password and Confirm Password do not match.';

                    return false;
                }

                return true;
            }
        </script>
    @endif
    @if (auth()->user())
        @php
            $member = \App\Models\Member::where('userId', auth()->id())->first();
        @endphp

        @if (!$showChangePasswordModal && (!$member || !$member->terms_accepted))
            <!-- Modal -->
            <div id="termsModal" style="
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        ">
                <div style="
                width: 80%;
                height: 90%;
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            ">

                    <!-- Header -->
                    <div style="padding:15px; background:#1d3268; color:white;">
                        <h4 style="margin:0;">Terms & Conditions</h4>
                    </div>

                    <!-- PDF Preview -->
                    <iframe src="{{ route('terms.preview') }}" style="flex:1; border:none;">
                    </iframe>

                    <!-- Footer -->
                    <div style="padding:15px; text-align:center;">
                        <form method="POST" action="{{ route('terms.accept') }}">
                            @csrf
                            <button type="submit" style="
                            background:#1d3268;
                            color:white;
                            padding:10px 25px;
                            border:none;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                                Accept & Continue
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            <style id="p7i0cq">
                #termsModal {
                    animation: fadeIn 0.3s ease-in-out;
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                    }

                    to {
                        opacity: 1;
                    }
                }
            </style>
        @endif
    @endif

    <div class="modal fade" id="updateProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content border-0 shadow-lg" style="border-radius:20px; overflow:hidden;">

                <div style="height:5px; background:linear-gradient(90deg,#1d3268,#4f8cff);"></div>

                {{-- Header --}}
                <div class="modal-header border-0 pb-0 pt-3 px-4">
                    <h5 class="fw-bold" style="color:#1d3268;font-size:17px;">
                        Complete your profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body px-4 pb-4 pt-3" style="color:#333;font-size:15px;font-family:sans-serif;">

                    <form method="POST" action="{{ route('member.update', $member->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $member->id }}">

                        {{-- ================= PERSONAL ================= --}}
                        @php
                            $personalFields = ['Title', 'First Name', 'Last Name', 'Gender', 'Birth Date'];
                            $personal = collect($missingFields)->filter(fn($f) => in_array($f, $personalFields));
                            $col = $personal->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($personal->isNotEmpty())
                            <p class="section-label">Personal</p>
                            <div class="row g-3">

                                @if (in_array('Title', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Title</label>
                                        <select name="title" class="form-control custom-input">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('First Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">First Name</label>
                                        <input type="text" name="firstName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Last Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Last Name</label>
                                        <input type="text" name="lastName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Gender', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Gender</label>
                                        <select name="gender" class="form-control custom-input">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('Birth Date', $missingFields))
                                    <div class="{{ $col }}">
                                        <label class="field-label">Birth Date</label>
                                        <input type="date" name="birthDate" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= KEYWORDS ================= --}}
                        @if (in_array('Keywords', $missingFields))
                            <p class="section-label mt-3">Keywords</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="field-label">Keyword 1</label>
                                    <input type="text" name="keyword1" class="form-control custom-input">
                                </div>

                                <div class="col-12">
                                    <label class="field-label">Keyword 2</label>
                                    <input type="text" name="keyword2" class="form-control custom-input">
                                </div>

                                <div class="col-12">
                                    <label class="field-label">Keyword 3</label>
                                    <input type="text" name="keyword3" class="form-control custom-input">
                                </div>
                            </div>
                        @endif


                        {{-- ================= CONTACT ================= --}}
                        @php
                            $contactFields = ['Email', 'Contact Number', 'Address Line 1', 'Address Line 2', 'City', 'Landmark'];
                            $contact = collect($missingFields)->filter(fn($f) => in_array($f, $contactFields));
                            $col = $contact->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($contact->isNotEmpty())
                            <p class="section-label mt-3">Contact</p>
                            <div class="row g-3">

                                @if (in_array('Email', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Contact Number', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Contact Number</label>
                                        <input type="text" name="contactNo" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Address Line 1', $missingFields))
                                    <div class="col-12">
                                        <label>Address Line 1</label>
                                        <input type="text" name="addressLine1" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Address Line 2', $missingFields))
                                    <div class="col-12">
                                        <label>Address Line 2</label>
                                        <input type="text" name="addressLine2" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('City', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>City</label>
                                        <select name="city" class="form-control custom-input">
                                            <option value="">Select City</option>
                                            @foreach ($city as $cities)
                                                <option value="{{ $cities->id }}">{{ $cities->cityName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if (in_array('Landmark', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Landmark</label>
                                        <select name="landmark" id="modalLandmark" class="form-control custom-input">
                                            <option value="">Select Landmark</option>
                                            @foreach ($landmarks as $lm)
                                                <option value="{{ $lm }}">{{ $lm }}</option>
                                            @endforeach
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-2" id="modalOtherLandmark" style="display:none;">
                                        <input type="text" name="other_landmark" class="form-control" placeholder="Enter Landmark">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= BUSINESS ================= --}}
                        @php
                            $businessFields = ['Company Name', 'Website', 'GST/PAN'];
                            $business = collect($missingFields)->filter(fn($f) => in_array($f, $businessFields));
                            $col = $business->count() == 1 ? 'col-12' : 'col-6';
                        @endphp

                        @if ($business->isNotEmpty())
                            <p class="section-label mt-3">Business</p>
                            <div class="row g-3">

                                @if (in_array('Company Name', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Company Name</label>
                                        <input type="text" name="companyName" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('GST/PAN', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>GST / PAN</label>
                                        <input type="text" name="gstinPan" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Website', $missingFields))
                                    <div class="col-12">
                                        <label>Website</label>
                                        <input type="text" name="webSite" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        {{-- ================= UPLOAD ================= --}}
                        @php
                            $uploadFields = ['Profile Photo', 'Company Logo'];
                            $upload = collect($missingFields)->filter(fn($f) => in_array($f, $uploadFields));
                            $col = $upload->count() == 1 ? 'col-12' : 'col-6';

                        @endphp

                        @if ($upload->isNotEmpty())
                            <p class="section-label mt-3">Uploads</p>
                            <div class="row g-3">

                                @if (in_array('Profile Photo', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Profile Photo</label>
                                        <input type="file" name="profilePhoto" class="form-control custom-input">
                                    </div>
                                @endif

                                @if (in_array('Company Logo', $missingFields))
                                    <div class="{{ $col }}">
                                        <label>Company Logo</label>
                                        <input type="file" name="companyLogo" class="form-control custom-input">
                                    </div>
                                @endif

                            </div>
                        @endif


                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-later" data-bs-dismiss="modal">Later</button>
                            <button type="submit" class="btn btn-save">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (!$showChangePasswordModal && $member && $member->terms_accepted && count($missingFields) > 0 && !session('profileUpdated'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
                myModal.show();
            });
        </script>
    @endif

    <style>
        .section-label {
            font-size: 11px;
            font-weight: 700;
            color: #1d3268;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 0 0 12px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #6c7a9c;
            margin-bottom: 5px;
            letter-spacing: 0.3px;
        }

        .custom-input {
            border-radius: 12px;
            padding: 9px 13px;
            border: 1px solid #e3e7f1;
            font-size: 13px;
            color: #1d3268;
            transition: border-color .2s, box-shadow .2s;
            background: #fff;
        }

        .custom-input:focus {
            border-color: #4f8cff;
            box-shadow: 0 0 0 3px rgba(79, 140, 255, .12);
            outline: none;
        }

        .custom-input::placeholder {
            color: #adb5cc;
        }

        .upload-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: 1.5px dashed #c8d1e8;
            border-radius: 12px;
            padding: 14px 8px;
            cursor: pointer;
            background: #fafbfd;
            transition: border-color .2s, background .2s;
        }

        .upload-box:hover {
            border-color: #4f8cff;
            background: #f0f5ff;
        }

        .upload-box span {
            font-size: 11px;
            color: #6c7a9c;
        }

        .btn-later {
            padding: 10px 20px;
            border-radius: 12px;
            border: 1px solid #e3e7f1;
            background: #f4f6fb;
            color: #6c7a9c;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-later:hover {
            background: #e3e7f1;
            color: #1d3268;
        }

        .btn-save {
            padding: 10px 28px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #1d3268, #4f8cff);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            transition: opacity .2s, transform .15s;
        }

        .btn-save:hover {
            opacity: .92;
            transform: translateY(-1px);
            color: #fff;
        }
    </style>
    <div class="container mt-4">
        <div class="row">
            <!-- Left Section (7 Columns) -->
            <div class="col-lg-8 col-md-12">
                <style>
                    .compact-stats .stat-card {
                        padding: 8px;
                        border-radius: 10px;
                    }

                    .compact-stats .stat-value {
                        font-size: 1.25rem;
                        font-weight: 700;
                        color: #ab2626;
                        line-height: 1.2;
                    }

                    .compact-stats .stat-label {
                        font-size: 0.75rem;
                        color: #6c757d;
                        text-transform: uppercase;
                        font-weight: 600;
                        margin-top: 2px;
                    }

                    .compact-stats .stat-icon {
                        position: static !important;
                        font-size: 1.75rem;
                        color: rgba(108, 117, 125, 0.6);
                    }
                </style>
                <div class="row mb-3 compact-stats">
                    <div class="col-md-4 col-12 mb-2">
                        <div class="card shadow-sm border-0 stat-card">
                            <div class="d-flex align-items-center justify-content-between p-2">
                                <div>
                                    <div class="stat-value">₹ {{ number_format($totalBusinessAmount ?? 0, 0) }}</div>
                                    <div class="stat-label">Total Business</div>
                                </div>
                                <i class="bi bi-cash-stack stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <div class="card shadow-sm border-0 stat-card">
                            <div class="d-flex align-items-center justify-content-between p-2">
                                <div>
                                    <div class="stat-value">{{ $totalReferences }}</div>
                                    <div class="stat-label">Total Referrals</div>
                                </div>
                                <i class="bi bi-person-rolodex stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <div class="card shadow-sm border-0 stat-card">
                            <div class="d-flex align-items-center justify-content-between p-2">
                                <div>
                                    <div class="stat-value">{{ $totalIbms }}</div>
                                    <div class="stat-label">Total IBMs</div>
                                </div>
                                <i class="bi bi-calendar-event stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Cities Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="content p-3">
                                        <h2 class="fw-bold text-gradient">{{ $cityCount }}</h2>
                                        <p class="text-uppercase text-muted fw-semibold">Cities</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Icon positioned at the bottom right, overlapping slightly -->
                            <i class="bi bi-buildings stat-icon position-absolute" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                        </div>
                    </div>

                    <!-- Circles Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="content p-3">
                                        <h2 class="fw-bold text-gradient">{{ $circleCount }}</h2>
                                        <p class="text-uppercase text-muted fw-semibold">Circles</p>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-bullseye stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                        </div>
                    </div>

                    <!-- Members Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="content p-3">
                                        <h2 class="fw-bold text-gradient">{{ $membersCount }}</h2>
                                        <p class="text-uppercase text-muted fw-semibold">Members</p>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-people stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                        </div>
                    </div>
                </div>



                {{-- <h1 class="text-center card-title" id="leaderboard-title"></h1>

                <script>
                    const date = new Date();
                    const lastMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1);
                    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    document.getElementById("leaderboard-title").innerHTML = `Leaderboard - ${months[lastMonth.getMonth()]} ${date.getFullYear()}`;
                </script> --}}
            </div>
            <!-- Right Section (5 Columns) -->
            <div class="col-lg-4 col-md-12">
                <div class="row">
                    @php
                        $authUserId = Auth::id();

                        // Received References
                        $myReceivedReferences = \App\Models\CircleMeetingMembersReference::where('memberId', $authUserId)->where('status', 'Active')->count();

                        // Given References
                        $myGivenReferences = \App\Models\CircleMeetingMembersReference::where('referenceGiverId', $authUserId)->where('status', 'Active')->count();

                        // Given Business Amount
                        $myGivenBusiness = \App\Models\CircleMeetingMembersBusiness::where('businessGiverId', $authUserId)->where('status', 'Active')->sum('amount');

                        // Received Business Amount
                        $myReceivedBusiness = \App\Models\CircleMeetingMembersBusiness::where('loginMemberId', $authUserId)->where('status', 'Active')->sum('amount');
                    @endphp

                    <div class="col-lg-12 col-md-12 ">
                        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                            <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #1d3268 0%, #3a5bb0 100%);">
                                <h5 class="mb-0 fw-bold text-white"><i class="bi bi-person-lines-fill me-2"></i>My Stats</h5>
                            </div>
                            <div class="card-body p-3 mt-3 mb-3">
                                <div class="row g-3">
                                    <!-- Received References -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #28a745 !important; background-color: #fff;">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(40, 167, 69, 0.1); color: #28a745; flex-shrink: 0;">
                                                <i class="bi bi-arrow-down-left-circle fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Received Refs</small>
                                                <h5 class="mb-0 fw-bold text-dark">{{ $myReceivedReferences }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Given References -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #17a2b8 !important; background-color: #fff;">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; flex-shrink: 0;">
                                                <i class="bi bi-arrow-up-right-circle fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Given Refs</small>
                                                <h5 class="mb-0 fw-bold text-dark">{{ $myGivenReferences }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Received Business -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #dc3545 !important; background-color: #fff;">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(220, 53, 69, 0.1); color: #dc3545; flex-shrink: 0;">
                                                <i class="bi bi-cash-coin fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Received Business</small>
                                                <h5 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($myReceivedBusiness, 0) }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Given Business -->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #ffc107 !important; background-color: #fff;">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(255, 193, 7, 0.1); color: #ffc107; flex-shrink: 0;">
                                                <i class="bi bi-currency-exchange fs-5"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Given Business</small>
                                                <h5 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($myGivenBusiness, 0) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <script>
                        function copyMeetingLink() {
                            var copyText = document.getElementById("shareableMeetingLink").value;
                            navigator.clipboard.writeText(copyText).then(function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Link copied!',
                                    text: 'The link has been copied to your clipboard.',
                                    confirmButtonText: 'OK'
                                });
                            }, function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Could not copy the link. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }

                        function openInvitePage(url) {
                            window.open(url, '_blank');
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
    {{-- <style>
        .uplfeed-card {
            background: #f2f2f2;

            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 505px; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-only-card {
            padding: 0;
        }

        .uplfeed-img-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .uplfeed-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }
    </style>
    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        🏏 UBN Primer League 2.0 Sponsers
                    </h5>
                </div>
            </div>

            <div class="card-body p-3">

                <!-- ✅ ONLY 2 CARDS -->
                <div class="row row-cols-1 row-cols-md-2 g-4">

                    <!-- ✅ CARD 1 → Title Sponsor -->
                    <div class="col">
                        <div class="uplfeed-card image-only-card">
                            <div class="uplfeed-img-section">
                                <div class="uplfeed-img-wrapper">
                                    <!-- 🔥 Replace with your actual image name -->
                                    <img src="uplcricket_images/title_sponser.jpeg" class="uplfeed-img" alt="Title Sponsor">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ CARD 2 → Co Sponsor -->
                    <div class="col">
                        <div class="uplfeed-card image-only-card">

                            <div class="uplfeed-img-section">
                                <div class="uplfeed-img-wrapper">
                                    <!-- 🔥 Replace with your actual image name -->
                                    <img src="uplcricket_images/co_sponser.jpeg" class="uplfeed-img" alt="Co Sponsor">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <style>
        .captianfeed-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 220px; */
            transition: 0.3s;
        }

        .captianfeed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .image-only-card {
            padding: 0;
        }

        .captianfeed-img-section,
        .captianfeed-img-wrapper {
            width: 100%;
            height: 100%;
        }

        .captianfeed-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 🔥 IMPORTANT FIX */
            display: block;
        }
    </style>

    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <h5 class="fw-bold mb-0">🏏 UBN Primer League 2.0 Team & Captains</h5>
            </div>

            <div class="card-body p-3">

                <!-- ✅ 6 CARDS GRID -->
                <div class="row row-cols-2 row-cols-md-3 g-4">

                    <!-- TEAM 1 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team1.jpeg') }}" class="captianfeed-img" alt="Team 1 Captain">
                        </div>
                    </div>

                    <!-- TEAM 2 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team2.jpeg') }}" class="captianfeed-img" alt="Team 2 Captain">
                        </div>
                    </div>

                    <!-- TEAM 3 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team3.jpeg') }}" class="captianfeed-img" alt="Team 3 Captain">
                        </div>
                    </div>

                    <!-- TEAM 4 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team4.jpeg') }}" class="captianfeed-img" alt="Team 4 Captain">
                        </div>
                    </div>

                    <!-- TEAM 5 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team5.jpeg') }}" class="captianfeed-img" alt="Team 5 Captain">
                        </div>
                    </div>

                    <!-- TEAM 6 -->
                    <div class="col">
                        <div class="captianfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/team6.jpeg') }}" class="captianfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endif
    <style>
        .sponsorfeed-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            /* height: 220px; */
            transition: 0.3s;
        }

        .sponsorfeed-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .image-only-card {
            padding: 0;
        }

        .sponsorfeed-img-section,
        .sponsorfeed-img-wrapper {
            width: 100%;
            height: 100%;
        }

        .sponsorfeed-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 🔥 IMPORTANT FIX */
            display: block;
        }
    </style>

    @php
        $cityId = \App\Models\Member::where('userId', auth()->id())->value('cityId');
    @endphp
    @if ($cityId == 3)
        <div class="card shadow-sm mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <h5 class="fw-bold mb-0">🏏 UBN Primer League 2.0 Tournament Essentials Suponsors</h5>
            </div>

            <div class="card-body p-3">

                <!-- ✅ 6 CARDS GRID -->
                <div class="row row-cols-1 row-cols-md-4 g-4">

                    <!-- TEAM 1 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/anchor_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 1 Captain">
                        </div>
                    </div>

                    <!-- TEAM 2 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/bat_ball_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 2 Captain">
                        </div>
                    </div>

                    <!-- TEAM 3 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/six_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 3 Captain">
                        </div>
                    </div>

                    <!-- TEAM 4 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/four_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 4 Captain">
                        </div>
                    </div>

                    <!-- TEAM 5 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/noball_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 5 Captain">
                        </div>
                    </div>

                    <!-- TEAM 6 -->
                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/sound_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/umpire_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/water_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/wicket_sopnsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/wide_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/t-shirt_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                    <div class="col">
                        <div class="sponsorfeed-card image-only-card">
                            <img src="{{ asset('uplcricket_images/photographts_sponsor.jpeg') }}" class="sponsorfeed-img" alt="Team 6 Captain">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endif --}}
    <h1 class="text-center card-title fs-2 " id="leaderboard-title"></h1>

    <script>
        const date = new Date();
        const lastMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1);
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        document.getElementById("leaderboard-title").innerHTML = `Leaderboard - ${months[lastMonth.getMonth()]} ${date.getFullYear()}`;
    </script>
    <style>
        .ann-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 0.5px solid rgba(0, 0, 0, 0.12);
            background: #fff;
            margin-top: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .ann-accent {
            height: 4px;
            background: linear-gradient(90deg, #ff7a00, #1d3268);
        }

        .ann-header {
            background: linear-gradient(90deg, #1d3268, #294a96);
            color: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
        }

        .ann-body {
            padding: 1.5rem;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            position: relative;
            min-height: 180px;
        }

        .ann-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #EEEDFE;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 24px;
        }

        .ann-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #EEEDFE;
            color: #3C3489;
            margin-bottom: 10px;
        }

        .ann-title {
            font-size: 20px;
            font-weight: 700;
            color: #1d3268;
            margin-bottom: 8px;
        }

        .ann-desc {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.8;
            margin: 0;
        }

        .ann-time {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            background: #f3f4f6;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #1d3268;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .ann-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #9d9c98;
            font-size: 15px;
            font-weight: 500;
        }
    </style>

    <div class="ann-wrapper">

        {{-- Header --}}
        <div class="ann-header">
            <span>📢 Latest Announcements</span>
        </div>

        {{-- Accent --}}
        <div class="ann-accent"></div>

        @if ($announcements->count() > 0)
            <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

                {{-- Indicators --}}
                <div class="carousel-indicators">

                    @foreach ($announcements as $key => $announcement)
                        <button type="button" data-bs-target="#announcementCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                        </button>
                    @endforeach

                </div>

                {{-- Carousel Items --}}
                <div class="carousel-inner">

                    @foreach ($announcements as $key => $announcement)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                            <div class="ann-body">

                                {{-- Time --}}
                                <div class="ann-time">
                                    ⏰ {{ $announcement->created_at->timezone('Asia/Kolkata')->diffForHumans() }}
                                </div>

                                {{-- Icon --}}
                                <div class="ann-icon-box">
                                    🔔
                                </div>

                                {{-- Content --}}
                                <div style="flex:1; min-width:0;">

                                    <span class="ann-badge">
                                        ⚡ Active
                                    </span>

                                    <div class="ann-title">
                                        {{ $announcement->title }}
                                    </div>

                                    <p class="ann-desc">
                                        {{ $announcement->description }}
                                    </p>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        @else
            <div class="ann-empty">
                🚫 No Active Announcement Available
            </div>
        @endif

    </div>
    <style>
        .banner-slider-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }

        .banner-slider-header {
            background: linear-gradient(90deg, #1d3268, #294a96);
            color: #fff;
            padding: 15px 20px;
        }

        .banner-slider-img {
            width: 100%;
            height: 500px;
            object-fit: initial;
            background: #f8f9fa;
        }

        .carousel-item {
            transition: transform 1s ease-in-out;
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 18px;
        }

        @media (max-width: 768px) {
            .banner-slider-img {
                height: 220px;
            }
        }
    </style>

    <div class="card banner-slider-card mt-4">

        {{-- Header --}}
        <div class="banner-slider-header">
            <h4 class="fw-bold mb-0">
                🎉 Latest Banners
            </h4>
        </div>

        {{-- Slider --}}
        <div id="dashboardBannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

            {{-- Indicators --}}
            <div class="carousel-indicators">

                @foreach ($banners->take(5) as $key => $banner)
                    <button type="button" data-bs-target="#dashboardBannerSlider" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                    </button>
                @endforeach

            </div>

            {{-- Images --}}
            <div class="carousel-inner">

                @foreach ($banners->take(5) as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                        <img src="{{ asset('banners/' . $banner->image) }}" class="d-block w-100 banner-slider-img" alt="Banner">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .fb-card {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            height: 100%;
            display: flex;
            flex-direction: column;
            font-family: sans-serif;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .fb-card-img-wrapper {
            width: 100%;
            padding-top: 100%;
            /* 1:1 Aspect Ratio */
            position: relative;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .fb-card-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fb-card-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .fb-card-title {
            color: #1d3268;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .fb-card-subtitle {
            color: #65676b;
            font-size: 15px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .fb-card-info {
            color: #65676b;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .fb-card-info i {
            color: #e76a35;
        }

        .fb-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e76a35;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .fb-btn {
            width: 100%;
            border: none;
            border-radius: 6px;
            padding: 8px 0;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .fb-btn:hover {
            text-decoration: none;
        }

        .fb-btn-primary {
            background-color: #1d3268;
            color: #fff;
        }

        .fb-btn-primary:hover {
            background-color: #15244d;
            color: #fff;
        }

        .fb-btn-secondary {
            background-color: #e4e6eb;
            color: #1d3268;
            margin-top: 10px;
        }

        .fb-btn-secondary:hover {
            background-color: #d8dadf;
            color: #1d3268;
        }

        .fb-btn-disabled {
            background-color: #e4e6eb;
            color: #bcc0c4;
            cursor: default;
        }
    </style>

    <div class="leaderboard mt-3">
        <div class="row g-4">
            {{-- Card 1: Top IBM Member --}}
            @if ($circlecalls)
                <div class="col-sm-6 col-lg-3">
                    <div class="fb-card shadow-sm">
                        <div class="fb-card-img-wrapper">
                            <span class="fb-badge">Top IBM Member</span>
                            <img src="{{ asset('ProfilePhoto/' . ($circlecalls['member']->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                        </div>
                        <div class="fb-card-body">
                            <h5 class="fb-card-title">{{ $circlecalls['member']->firstName }} {{ $circlecalls['member']->lastName }}</h5>

                            <div class="fb-card-subtitle">
                                <i class="bi bi-people-fill"></i>
                                {{ $circlecalls['member']->circle->circleName }}
                                <span>&bull;</span>
                                <b><span>{{ $circlecalls['count'] }} IBMs</span></b>
                            </div>

                            <div class="fb-card-info">
                                @if (!empty($circlecalls['member']->companyName))
                                    <div><i class="bi bi-building me-1"></i> <b>{{ $circlecalls['member']->companyName }}</b>
                                    </div>
                                @endif
                                @if (!empty($circlecalls['member']->bCategory->categoryName))
                                    <div><i class="bi bi-tag me-1"></i> <b>{{ $circlecalls['member']->bCategory->categoryName }}</b></div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <!-- Connect Button -->
                                @php
                                    $connectionStatus = $circlecalls['member']->connection_status ?? 'Not Connected';
                                @endphp
                                @if ($connectionStatus == 'Connected')
                                    <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                @elseif ($connectionStatus == 'Accepted')
                                    <button class="fb-btn fb-btn-primary">Message</button>
                                @elseif ($connectionStatus == 'Pending')
                                    <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                @else
                                    <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                        @csrf
                                        <input type="hidden" value="{{ $circlecalls['member']->id }}" name="memberId">
                                        <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                    </form>
                                @endif

                                <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                    Inductions - {{ $circlecalls['member']->sponsored->count() }}
                                </div>

                                <!-- View Profile -->
                                <a href="{{ route('foundPersonDetails', $circlecalls['member']->id) }}" class="text-decoration-none d-block w-100">
                                    <button class="fb-btn fb-btn-secondary">View Profile</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card 2: Top Business Leader --}}
            @if ($busGiver)
                <div class="col-sm-6 col-lg-3">
                    <div class="fb-card shadow-sm">
                        <div class="fb-card-img-wrapper">
                            <span class="fb-badge">Top Business Leader</span>
                            <img src="{{ asset('ProfilePhoto/' . ($busGiver['member']->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                        </div>
                        <div class="fb-card-body">
                            <h5 class="fb-card-title">{{ $busGiver['member']->firstName }} {{ $busGiver['member']->lastName }}</h5>

                            <div class="fb-card-subtitle">
                                <i class="bi bi-people-fill"></i>
                                {{ $busGiver['member']->circle->circleName ?? 'N/A' }}
                                <span>&bull;</span>
                                {{-- <span>Business Given: {{ $busGiver['count'] }}</span> --}}
                            </div>

                            <div class="fb-card-info">
                                <div><i class="bi bi-currency-rupee me-1"></i> <b>{{ $busGiver['amount'] }}</b></div>
                                @if (!empty($busGiver['member']->companyName))
                                    <div><i class="bi bi-building me-1"></i> <b>{{ $busGiver['member']->companyName }}</b>
                                    </div>
                                @endif
                                @if (!empty($busGiver['member']->bCategory->categoryName))
                                    <div><i class="bi bi-tag me-1"></i> <b>{{ $busGiver['member']->bCategory->categoryName }}</b></div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <!-- Connect Button -->
                                @php
                                    $connectionStatus = $busGiver['member']->connection_status ?? 'Not Connected';
                                @endphp
                                @if ($connectionStatus == 'Connected')
                                    <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                @elseif ($connectionStatus == 'Accepted')
                                    <button class="fb-btn fb-btn-primary">Message</button>
                                @elseif ($connectionStatus == 'Pending')
                                    <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                @else
                                    <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                        @csrf
                                        <input type="hidden" value="{{ $busGiver['member']->id }}" name="memberId">
                                        <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                    </form>
                                @endif

                                <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                    Inductions - {{ $busGiver['member']->sponsored->count() }}
                                </div>

                                <!-- View Profile -->
                                <a href="{{ route('foundPersonDetails', $busGiver['member']->id) }}" class="text-decoration-none d-block w-100">
                                    <button class="fb-btn fb-btn-secondary">View Profile</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card 3: Top Reference Giver --}}
            @if ($refGiver)
                <div class="col-sm-6 col-lg-3">
                    <div class="fb-card shadow-sm">
                        <div class="fb-card-img-wrapper">
                            <span class="fb-badge">Top Reference Giver</span>
                            <img src="{{ asset('ProfilePhoto/' . ($refGiver['member']->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                        </div>
                        <div class="fb-card-body">
                            <h5 class="fb-card-title">{{ $refGiver['member']->firstName }} {{ $refGiver['member']->lastName }}</h5>

                            <div class="fb-card-subtitle">
                                <i class="bi bi-people-fill"></i>
                                {{ $refGiver['member']->circle->circleName ?? 'N/A' }}
                                <span>&bull;</span>
                                <b><span>References Given: {{ $refGiver['count'] ?? '0' }}</span></b>
                            </div>

                            <div class="fb-card-info">
                                @if (!empty($refGiver['member']->companyName))
                                    <div><i class="bi bi-building me-1"></i> <b>{{ $refGiver['member']->companyName }}</b></div>
                                @endif
                                @if (!empty($refGiver['member']->bCategory->categoryName))
                                    <div><i class="bi bi-tag me-1"></i> <b>{{ $refGiver['member']->bCategory->categoryName }}</b></div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <!-- Connect Button -->
                                @php
                                    $connectionStatus = $refGiver['member']->connection_status ?? 'Not Connected';
                                @endphp
                                @if ($connectionStatus == 'Connected')
                                    <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                @elseif ($connectionStatus == 'Accepted')
                                    <button class="fb-btn fb-btn-primary">Message</button>
                                @elseif ($connectionStatus == 'Pending')
                                    <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                @else
                                    <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                        @csrf
                                        <input type="hidden" value="{{ $refGiver['member']->id }}" name="memberId">
                                        <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                    </form>
                                @endif

                                <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                    Inductions - {{ $refGiver['member']->sponsored->count() }}
                                </div>

                                <!-- View Profile -->
                                <a href="{{ route('foundPersonDetails', $refGiver['member']->id) }}" class="text-decoration-none d-block w-100">
                                    <button class="fb-btn fb-btn-secondary">View Profile</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card 4: Top Induction --}}
            @if (isset($induction) && $induction)
                <div class="col-sm-6 col-lg-3">
                    <div class="fb-card shadow-sm">
                        <div class="fb-card-img-wrapper">
                            <span class="fb-badge">Top Induction</span>
                            <img src="{{ asset('ProfilePhoto/' . ($induction['member']->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                        </div>
                        <div class="fb-card-body">
                            <h5 class="fb-card-title">{{ $induction['member']->firstName }} {{ $induction['member']->lastName }}</h5>

                            <div class="fb-card-subtitle">
                                <i class="bi bi-people-fill"></i>
                                {{ $induction['member']->circle->circleName ?? 'N/A' }}
                                <span>&bull;</span>
                                <b><span>Inductions: {{ $induction['count'] ?? '0' }}</span></b>
                            </div>

                            <div class="fb-card-info">
                                @if (!empty($induction['member']->companyName))
                                    <div><i class="bi bi-building me-1"></i> <b>{{ $induction['member']->companyName }}</b></div>
                                @endif
                                @if (!empty($induction['member']->bCategory->categoryName))
                                    <div><i class="bi bi-tag me-1"></i> <b>{{ $induction['member']->bCategory->categoryName }}</b></div>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <!-- Connect Button -->
                                @php
                                    $connectionStatus = $induction['member']->connection_status ?? 'Not Connected';
                                @endphp
                                @if ($connectionStatus == 'Connected')
                                    <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                @elseif ($connectionStatus == 'Accepted')
                                    <button class="fb-btn fb-btn-primary">Message</button>
                                @elseif ($connectionStatus == 'Pending')
                                    <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                @else
                                    <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                        @csrf
                                        <input type="hidden" value="{{ $induction['member']->id }}" name="memberId">
                                        <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                    </form>
                                @endif

                                <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                    Inductions - {{ $induction['member']->sponsored->count() }}
                                </div>

                                <!-- View Profile -->
                                <a href="{{ route('foundPersonDetails', $induction['member']->id) }}" class="text-decoration-none d-block w-100">
                                    <button class="fb-btn fb-btn-secondary">View Profile</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ================= TOP INDUCTIONS SECTION ================= --}}

    <style>
        .induction-section {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .induction-header {
            background: linear-gradient(90deg, #1d3268, #294a96);
            padding: 18px 22px;
            color: #fff;
        }

        .induction-header h5 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .induction-content {
            padding: 25px;
        }

        .induction-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: 0.3s ease;
            height: 100%;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .induction-card:hover {
            transform: translateY(-5px);
        }

        .induction-img-wrapper {
            position: relative;
            width: 100%;
            height: 240px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .induction-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .induction-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #ff7a00;
            color: #fff;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            z-index: 10;
        }

        .induction-body {
            padding: 18px;
        }

        .induction-name {
            font-size: 20px;
            font-weight: 700;
            color: #1d3268;
            margin-bottom: 8px;
        }

        .induction-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .induction-subtitle i {
            color: #ff7a00;
        }

        .induction-info {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .induction-info i {
            color: #ff7a00;
        }

        .induction-count {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: #1d3268;
            margin-bottom: 15px;
        }

        .induction-btn {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 10px;
            background: #1d3268;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .induction-btn:hover {
            background: #ff7a00;
            color: #fff;
        }
    </style>

    <div class="induction-section mt-4">
        <div class="induction-header">
            <h5>
                <i class="bi bi-people-fill me-2"></i>
                Top Inductions
            </h5>
        </div>
        <div class="induction-content">
            <div class="row g-4">
                @foreach ($topInductions as $topinduction)
                    <div class="col-sm-6 col-lg-3">
                        <div class="fb-card shadow-sm">
                            <div class="fb-card-img-wrapper">
                                <span class="fb-badge">Top Induction</span>
                                <img src="{{ asset('ProfilePhoto/' . ($topinduction['member']->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                            </div>
                            <div class="fb-card-body">
                                <h5 class="fb-card-title">{{ $topinduction['member']->firstName }} {{ $topinduction['member']->lastName }}</h5>

                                <div class="fb-card-subtitle">
                                    <i class="bi bi-people-fill"></i>
                                    {{ $topinduction['member']->circle->circleName ?? 'N/A' }}
                                    <span>&bull;</span>
                                    <b><span>Inductions: {{ $topinduction['count'] ?? '0' }}</span></b>
                                </div>

                                <div class="fb-card-info">
                                    @if (!empty($topinduction['member']->companyName))
                                        <div><i class="bi bi-building me-1"></i> <b>{{ $topinduction['member']->companyName }}</b></div>
                                    @endif
                                    @if (!empty($topinduction['member']->bCategory->categoryName))
                                        <div><i class="bi bi-tag me-1"></i> <b>{{ $topinduction['member']->bCategory->categoryName }}</b></div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <!-- Connect Button -->
                                    @php
                                        $connectionStatus = $topinduction['member']->connection_status ?? 'Not Connected';

                                    @endphp
                                    @if ($connectionStatus == 'Connected')
                                        <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                    @elseif ($connectionStatus == 'Accepted')
                                        <button class="fb-btn fb-btn-primary">Message</button>
                                    @elseif ($connectionStatus == 'Pending')
                                        <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                    @else
                                        <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                            @csrf
                                            <input type="hidden" value="{{ $topinduction['member']->id }}" name="memberId">
                                            <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                        </form>
                                    @endif

                                    <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                        Inductions - {{ $topinduction['member']->sponsored->count() }}
                                    </div>

                                    <!-- View Profile -->
                                    <a href="{{ route('foundPersonDetails', $topinduction['member']->id) }}" class="text-decoration-none d-block w-100">
                                        <button class="fb-btn fb-btn-secondary">View Profile</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .view-more-btn {
            display: inline-block;
            padding: 8px 12px;
            border: 2px solid #fff;
            border-radius: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            /* letter-spacing: 0.5px; */
            transition: all 0.3s ease;
        }

        .view-more-btn span {
            margin-left: 6px;
        }

        .view-more-btn:hover {
            background-color: #fff;
            color: #1d3268;
        }
    </style>
    @if ($receivedRequests && $receivedRequests->count() > 0)
        <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Card Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people-fill me-2"></i>Connection Requests
                    </h5>
                    @if ($posts->count() >= 4)
                        <a href="{{ route('connection.myConnections') }}" class="view-more-btn">
                            View All <span>»</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @forelse ($receivedRequests->take(4) as $member)
                        <div class="col">
                            <div class="fb-card shadow-sm h-100">

                                <div class="fb-card-img-wrapper">
                                    <span class="fb-badge">Member</span>
                                    <img src="{{ asset('ProfilePhoto/' . ($member->receiver->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                                </div>

                                <div class="fb-card-body">

                                    <h5 class="fb-card-title">
                                        {{ $member->user->firstName ?? 'N/A' }}
                                        {{ $member->user->lastName ?? 'N/A' }}
                                    </h5>

                                    {{-- <div class="fb-card-info">
                                        <div><i class="bi bi-envelope-fill"></i> *****</div>
                                        <div><i class="bi bi-telephone-fill"></i> *****</div>
                                    </div> --}}

                                    @if (!empty($member->members->companyName) || !empty($member->members->bCategory->categoryName))
                                        <div class="fb-card-info">

                                            @if (!empty($member->members->companyName))
                                                <div>
                                                    <i class="bi bi-building"></i>
                                                    {{ $member->members->companyName }}
                                                </div>
                                            @endif

                                            @if (!empty($member->members->bCategory->categoryName))
                                                <div>
                                                    <i class="bi bi-tag"></i>
                                                    {{ $member->members->bCategory->categoryName }}
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    <div class="mt-auto">

                                        <a href="{{ route('foundPersonDetails', $member->members->id) }}" class="fb-btn fb-btn-primary w-100 text-decoration-none">
                                            View Profile
                                        </a>

                                        <div class="mt-2 text-center fw-bold" style="color:#1d3268;">
                                            Inductions -
                                            {{ $member->members->sponsored_count ?? $member->members->sponsored->count() }}
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <a href="{{ route('connection.reject', $member->id) }}" class="fb-btn fb-btn-secondary flex-fill">
                                                <i class="bi bi-x-circle me-2"></i> Reject
                                            </a>

                                            <a href="{{ route('connection.accept', $member->id) }}" class="fb-btn fb-btn-secondary flex-fill">
                                                <i class="bi bi-check-circle me-2"></i> Accept
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    @empty
                        <p class="text-center text-muted">No Connection Requests</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    @if ($latestCircleMembers && $latestCircleMembers->count() > 0)
        <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px; overflow: hidden;">

            <!-- Card Header -->
            <div class="card-header text-white" style="background:#1d3268;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people-fill me-2"></i>New Members Sportlights
                    </h5>
                    {{-- @if ($posts->count() >= 4)
                        <a href="{{ route('connection.myConnections') }}" class="view-more-btn">
                            View All <span>»</span>
                        </a>
                    @endif --}}
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @forelse ($latestCircleMembers->take(4) as $member)
                        <div class="col">
                            <div class="fb-card shadow-sm h-100">

                                <div class="fb-card-img-wrapper">
                                    <span class="fb-badge">Member</span>
                                    <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                                </div>

                                <div class="fb-card-body">

                                    <h5 class="fb-card-title">
                                        {{ $member->user->firstName ?? 'N/A' }}
                                        {{ $member->user->lastName ?? 'N/A' }}
                                    </h5>

                                    <div class="fb-card-subtitle">
                                        <i class="bi bi-people-fill"></i>
                                        {{ $member->circle->circleName ?? 'N/A' }}
                                    </div>


                                    {{-- <div class="fb-card-info">
                                        <div><i class="bi bi-envelope-fill"></i> *****</div>
                                        <div><i class="bi bi-telephone-fill"></i> *****</div>
                                    </div> --}}

                                    @if (!empty($member->companyName) || !empty($member->bCategory->categoryName))
                                        <div class="fb-card-info">

                                            @if (!empty($member->companyName))
                                                <div>
                                                    <i class="bi bi-building"></i>
                                                    {{ $member->companyName }}
                                                </div>
                                            @endif

                                            @if (!empty($member->bCategory->categoryName))
                                                <div>
                                                    <i class="bi bi-tag"></i>
                                                    {{ $member->bCategory->categoryName }}
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <!-- Connect Button -->
                                        @php
                                            $connectionStatus = $member->connection_status ?? 'Not Connected';
                                        @endphp
                                        @if ($connectionStatus == 'Connected')
                                            <button type="button" class="fb-btn fb-btn-disabled">Connected</button>
                                        @elseif ($connectionStatus == 'Accepted')
                                            <button class="fb-btn fb-btn-primary">Message</button>
                                        @elseif ($connectionStatus == 'Requested' || $connectionStatus == 'Pending')
                                            <button type="button" class="fb-btn fb-btn-disabled">Requested</button>
                                        @else
                                            <form action="{{ route('connect') }}" method="POST" class="d-block w-100">
                                                @csrf
                                                <input type="hidden" value="{{ $member->id }}" name="memberId">
                                                <button type="submit" class="fb-btn fb-btn-primary">Connect</button>
                                            </form>
                                        @endif

                                        <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                                            Inductions - {{ $member->sponsored->count() }}
                                        </div>

                                        <!-- View Profile -->
                                        <a href="{{ route('foundPersonDetails', $member->id) }}" class="text-decoration-none d-block w-100">
                                            <button class="fb-btn fb-btn-secondary">View Profile</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No New Members</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    <style>
        .feed-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            height: 320px;
            display: flex;
            flex-direction: column;
        }

        /* Top user info */
        .feed-body {
            padding: 10px 14px;
            flex-shrink: 0;
            /* ✅ Important */
        }

        .feed-user {
            display: flex;
            align-items: center;
        }

        .feed-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }

        .feed-name {
            font-size: 14px;
            font-weight: 600;
            color: #1d3268;
        }

        .feed-time {
            font-size: 12px;
            color: #777;
        }

        /* Image section */
        .feed-img-section {
            flex: 1;
            overflow: hidden;
        }

        .feed-img-wrapper {
            width: 100%;
            height: 100%;
        }

        .feed-img {
            width: 100%;
            height: 100%;
            object-fit: initial;
            /* ✅ FIXED (MOST IMPORTANT) */
        }

        .feed-img {
            width: 100%;
            height: 100%;
            object-fit: initial;
            /* ✅ FIXED */
        }

        .view-more-btn {
            display: inline-block;
            padding: 8px 15px;
            border: 2px solid #fff;
            border-radius: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .view-more-btn span {
            margin-left: 6px;
        }

        .view-more-btn:hover {
            background-color: #fff;
            color: #1d3268;
            font-weight: bold;
        }
    </style>


    <div class="card shadow-sm  mt-3"style="border-radius: 12px; overflow: hidden;">

        <div class="card-header text-white" style="background:#1d3268;">
            <div class="d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-newspaper me-2"></i>Network Feed
                </h5>

                @if ($posts->count() >= 4)
                    <a href="{{ route('social-wall.index') }}" class="view-more-btn">
                        VIEW ALL <span>»</span>
                    </a>
                @endif

            </div>

        </div>

        <div class="card-body p-3">

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                @foreach ($posts as $post)
                    @php
                        $member = optional($post->user->member);
                        $profile = $member->profilePhoto ?? 'profile.png';

                        $postImage = null;
                        if (!empty($post->attachment) && $post->status == 'Active') {
                            $postImage = asset($post->attachment);
                        }
                    @endphp

                    <div class="col">
                        <div class="feed-card">
                            <div class="feed-body feed-body-no-caption">
                                <div class="feed-user mb-0">
                                    <img src="{{ asset('ProfilePhoto/' . $profile) }}">
                                    <div>
                                        <div class="feed-name">
                                            {{ $post->user->firstName }} {{ $post->user->lastName }}
                                        </div>
                                        <div class="feed-time">
                                            {{ $post->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="feed-img-section">
                                <div class="feed-img-wrapper">
                                    <img src="{{ $postImage }}" class="feed-img" alt="Post image">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if ($meeting == null)
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card shadow-sm p-4 text-center">
                <h4 class="mb-4 fw-bold">Upcoming Circle Meetings</h4>
                <div class="alert alert-info" role="alert">
                    No upcoming circle meeting found
                </div>
            </div>
        </div>
    @else
        <div class="col-12 mt-3">
            <div class="card circleMeeting shadow-sm p-4 ">
                <h4 class="mb-4 fw-bold text-center" style="font-size: 22px; color:#1d3268;">&nbsp;Upcoming {{ $meeting->circle->circleName }} Circle Meetings
                </h4>
                <div class="card event-card-upcoming shadow-sm p-3 mb-3">
                    {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                    {{-- <span class="fw-bold">1.</span> --}}
                    {{-- <div class="fw-bold" style="color: #1d3268;"></div> --}}
                    {{-- <span class="fw-bold">{{ $meeting->date->format('j M Y') }} | {{ $meeting->meetingTime }}</span>
                        <i class="bi bi-clipboard me-2" onclick="copyMeetingLink()"></i>
                        <button class="btn btn-outline-primary btn-sm" onclick="openInvitePage('{{ $signedUrl }}')">Invite</button>
                    </div> --}}
                    <div class="d-flex justify-content-between align-items-center">

                        <span class="fw-bold">
                            {{ $meeting->date->format('j M Y') }} | {{ $meeting->meetingTime }}
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-clipboard fs-5" style="cursor:pointer;" onclick="copyMeetingLink()"></i>
                            <button class="btn btn-outline-primary btn-sm" onclick="openInvitePage('{{ $signedUrl }}')">
                                Invite
                            </button>
                        </div>

                    </div>
                    {{-- <div class="d-flex align-items-center mt-2">
                            <i class="bi bi-clock me-2"></i> 2 Hours
                        </div> --}}
                    <div class="d-flex align-items-center mt-2">
                        {{-- <i class="bi bi-people-fill me-2 text-muted"></i> <span class="fw-bold text-muted">{{ $meeting->circle->members->count() }}</span> --}}
                        <i class="bi bi-people-fill me-2 text-muted"></i>
                        <span class="fw-bold text-muted">
                            {{ $meeting->circle->members->where('status', 'Active')->count() }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill me-2 text-muted"></i> <span class="fw-bold text-muted">{{ $meeting->circle->city->cityName }}</span>
                    </div>
                    <hr>
                    <div class="text-primary fw-semibold" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Invited People - {{ $myInvites->count() }} <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <table class="table mt-2">
                            <tbody>
                                @foreach ($myInvites as $invite)
                                    <tr>
                                        <td><small class="text-muted">{{ $invite->personName }}</small>
                                        </td>
                                        <td><small class="text-muted">{{ $invite->personEmail }}</small>
                                        </td>
                                        <td><small class="text-muted">{{ $invite->personContact }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="shareableMeetingLink" value="{{ URL::signedRoute('visitor.form', ['slug' => $meeting->cm_slug, 'meetingId' => $meeting->id, 'ref' => auth()->user()->member->id]) }}">
    @endif
    @if ($categoryNames->isNotEmpty())
        <div class="card shadow-sm p-4 text-center mt-3">
            <h4 class="mb-4 fw-bold">Vacant Categories</h4>
            <div class="row">
                @foreach ($categoryNames as $categoryName)
                    <div class="col-md-6 mb-3">
                        <div class="card bottom-card border rounded p-2 pt-2" width="100%">
                            <h5 class="m-0 card-text fw-bold">{{ $categoryName }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    @if (count($nearestEvents) != 0)
        <div class="bg-light py-5">
            <div class="upcoming-events">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Events</h4>
                    <a href="#" class="fw-bold text-decoration-none" style="color: #1d3268;">See All</a>
                </div>

                <!-- Horizontal Scrollable Cards -->
                <div class="events-container d-flex">
                    @foreach ($nearestEvents as $event)
                        <div class="event-card">
                            <a href="{{ route('events.details', $event->id) }}" class="text-decoration-none">
                                <img src="{{ $event->event_banner ? url('Event/' . $event->event_banner) : asset('images/event_default.png') }}" alt="{{ $event->title }}">

                                <!-- Event Info Overlay -->
                                <div class="event-info">
                                    <h6 class="fw-bold">{{ $event->title }}</h6>
                                    <small class="fw-bold">📍 {{ $event->venue }}</small>
                                    {{-- <small>📍 {{ $event->venue }}, {{ $event->location }}</small> --}}
                                </div>

                                <!-- Event Details -->
                                <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                                    <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                                    {{-- <span>⏳ Time {{ $event->duration }}</span> --}}
                                    <span class="price-tag fw-bold">₹ {{ $event->fees }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style>
            .upcoming-events {
                display: none;
            }
        </style>
        {{-- <div class="bg-light py-5">
                <div class="upcoming-events">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold" style="color: #1d3268;">Upcoming Events</h4>
                    </div>
                    <p class="text-muted text-center"><b>No Events for now.</b></p>
                </div>
            </div> --}}
    @endif

    @if (count($nearestTraining) != 0)
        <div class="bg-light py-5">
            <div class="upcoming-events trainings">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Training Workshops</h4>
                    <a href="#" class="fw-bold text-decoration-none" style="color: #1d3268;">See All</a>
                </div>

                <!-- Horizontal Scrollable Cards -->
                <div class="events-container d-flex">
                    @foreach ($nearestTraining as $trainings)
                        <div class="event-card">
                            {{-- <a href="{{ route('events.details', $trainings->id) }}" class="text-decoration-none">
                                --}}
                            <img src="{{ $trainings->training_banner ? url('Training/' . $trainings->training_banner) : asset('images/profile.png') }}" alt="{{ $trainings->title }}">

                            <!-- Event Info Overlay -->
                            <div class="event-info">
                                <h6 class="fw-bold">{{ $trainings->title }}</h6>
                                <small class="fw-bold">📍 {{ $trainings->venue }}</small>
                                {{-- <small>📍 {{ $trainings->venue }}, {{ $trainings->location }}</small> --}}
                            </div>

                            <!-- Event Details -->
                            <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                                <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($trainings->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($trainings->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($trainings->end_time)->format('H:i') }}</span>
                                {{-- <span>⏳ Time {{ $trainings->duration }}</span> --}}
                                <span class="price-tag fw-bold">₹ {{ $trainings->fees }}</span>
                            </div>
                            </a>
                        </div>

                        <!-- Event Details -->
                        <div class="event-details d-flex justify-content-between align-items-center text-muted small">
                            <span class="fw-bold" style="color: #1d3268;">{{ \Carbon\Carbon::parse($trainings->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($trainings->start_time)->format('H:i') }} To {{ \Carbon\Carbon::parse($trainings->end_time)->format('H:i') }}</span>
                            {{-- <span>⏳ Time {{ $trainings->duration }}</span> --}}
                            <span class="price-tag fw-bold">₹ {{ $trainings->fees }}</span>
                        </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
        <style>
            .upcoming-events .trainings {
                display: none;
            }
        </style>
        {{-- <div class="bg-light py-5">
            <div class="upcoming-events trainings">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold" style="color: #1d3268;">Upcoming Training Workshops</h4>
                </div>
                <p class="text-muted text-center"><b>No Training Workshops for now.</b></p>
            </div>
        </div> --}}
    @endif



    </div>

    {{-- <!-- Right Section (5 Columns) -->
    <div class="col-lg-4 col-md-12">
        <div class="row">
            @php
                $authUserId = Auth::id();

                // Received References
                $myReceivedReferences = \App\Models\CircleMeetingMembersReference::where('memberId', $authUserId)->where('status', 'Active')->count();

                // Given References
                $myGivenReferences = \App\Models\CircleMeetingMembersReference::where('referenceGiverId', $authUserId)->where('status', 'Active')->count();

                // Given Business Amount
                $myGivenBusiness = \App\Models\CircleMeetingMembersBusiness::where('businessGiverId', $authUserId)->where('status', 'Active')->sum('amount');

                // Received Business Amount
                $myReceivedBusiness = \App\Models\CircleMeetingMembersBusiness::where('loginMemberId', $authUserId)->where('status', 'Active')->sum('amount');
            @endphp

            <div class="col-lg-12 col-md-12 ">
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #1d3268 0%, #3a5bb0 100%);">
                        <h5 class="mb-0 fw-bold text-white"><i class="bi bi-person-lines-fill me-2"></i>My Stats</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <!-- Received References -->
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #28a745 !important; background-color: #fff;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(40, 167, 69, 0.1); color: #28a745; flex-shrink: 0;">
                                        <i class="bi bi-arrow-down-left-circle fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Received Refs</small>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $myReceivedReferences }}</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Given References -->
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #17a2b8 !important; background-color: #fff;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; flex-shrink: 0;">
                                        <i class="bi bi-arrow-up-right-circle fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Given Refs</small>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $myGivenReferences }}</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Received Business -->
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #dc3545 !important; background-color: #fff;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(220, 53, 69, 0.1); color: #dc3545; flex-shrink: 0;">
                                        <i class="bi bi-cash-coin fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Received Business</small>
                                        <h5 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($myReceivedBusiness, 0) }}</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Given Business -->
                            <div class="col-6">
                                <div class="d-flex align-items-center p-2 border rounded h-100" style="border-left: 5px solid #ffc107 !important; background-color: #fff;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background-color: rgba(255, 193, 7, 0.1); color: #ffc107; flex-shrink: 0;">
                                        <i class="bi bi-currency-exchange fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem; letter-spacing: 0.5px; line-height: 1.2;">Given Business</small>
                                        <h5 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">₹{{ number_format($myGivenBusiness, 0) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <script>
                function copyMeetingLink() {
                    var copyText = document.getElementById("shareableMeetingLink").value;
                    navigator.clipboard.writeText(copyText).then(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Link copied!',
                            text: 'The link has been copied to your clipboard.',
                            confirmButtonText: 'OK'
                        });
                    }, function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Could not copy the link. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    });
                }

                function openInvitePage(url) {
                    window.open(url, '_blank');
                }
            </script>

        </div>
    </div>
    </div>
    </div> --}}

@endrole
