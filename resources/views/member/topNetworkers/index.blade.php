@extends('layouts.master')

@section('title', 'Top Networkers')

@section('content')
<style>
    /* Card Styles from components.connection.myConnection */
    .keyword-pill {
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

    .fb-card {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .fb-card-img-wrapper {
        width: 100%;
        padding-top: 100%;
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

    /* Custom Tabs from admin.connection.myConnection */
    .ubn-tab-nav {
        border-bottom: none;
        gap: 10px;
    }

    .ubn-tab-nav .nav-link {
        border: none;
        background-color: transparent;
        color: #64748b;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 50px;
        transition: all 0.2s;
    }

    .ubn-tab-nav .nav-link:hover {
        background-color: #f1f5f9;
        color: #1d3268;
    }

    .ubn-tab-nav .nav-link.active {
        background-color: #1d3268;
        color: #fff;
    }

    .ubn-tab-nav .nav-link.active .count {
        color: #fff;
        opacity: 0.8;
    }

    .ubn-tab-nav .count {
        margin-left: 5px;
        font-size: 0.85em;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Header & Tabs -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="bi bi-trophy-fill text-primary me-2"></i> Top Networkers
                        </h4>
                        <p class="text-muted small mb-0">Recognizing our top performing members</p>
                    </div>

                    <ul class="nav nav-pills ubn-tab-nav" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-target="tab-crorepati" href="javascript:void(0);">
                                Crorepati Givers <span class="count">({{ $crorepatiGivers->count() }})</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-target="tab-influencers" href="javascript:void(0);">
                                Top Influencers <span class="count">({{ $topInfluencers->count() }})</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div id="tab-content-area">
                <!-- Crorepati Givers -->
                <div id="tab-crorepati" class="tab-section active-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @forelse($crorepatiGivers as $giver)
                        @php $member = $giver->businessGiverMember; @endphp
                        @if($member)
                        <div class="col">
                            @include('member.topNetworkers.card', [
                            'member' => $member,
                            'badge' => 'Crorepati Giver',
                            'extraInfo' => 'Given: ₹' . number_format($giver->total_amount)
                            ])
                        </div>
                        @endif
                        @empty
                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted">No Crorepati Givers found yet.</h5>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Top Influencers -->
                <div id="tab-influencers" class="tab-section d-none">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @forelse($topInfluencers as $member)
                        <div class="col">
                            @include('member.topNetworkers.card', [
                            'member' => $member,
                            'badge' => 'Top Influencer',
                            'extraInfo' => 'Inductions: ' . $member->sponsees_count
                            ])
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted">No Top Influencers found yet.</h5>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.ubn-tab-nav .nav-link');
        const tabSections = document.querySelectorAll('.tab-section');

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove active class from all nav links
                navLinks.forEach(l => l.classList.remove('active'));

                // Add active to clicked link
                this.classList.add('active');

                // Hide all tab sections
                tabSections.forEach(tab => tab.classList.add('d-none'));

                // Show target tab
                const targetId = this.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if(targetSection) {
                    targetSection.classList.remove('d-none');
                }
            });
        });
    });
</script>
@endsection