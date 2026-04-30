<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBN Membership Contract</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --orange: #e8510a;
            --white: #ffffff;
            --text: #1d3268;
            --blue: #1d3268;
            --section-title: #c94a08;
            --bullet-orange: #1d3268;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #e8510a;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            gap: 32px;
        }

        .page {
            background: var(--white);
            border: 3px solid var(--blue);
            border-radius: 12px;
            width: 100%;
            /* max-width: 760px; */
            padding: 40px 44px 48px;
            position: relative;
        }



        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .header h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: 0.5px;
            color: var(--blue);
        }

        /* Logo */
        .logo img {
            height: 70px;
            width: auto;
        }

        /* Sections */
        .section {
            margin-bottom: 26px;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--section-title);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            border-bottom: 2px solid transparent;
            padding-bottom: 2px;
        }

        .section-intro {
            font-size: 0.99rem;
            color: var(--text);
            margin-bottom: 8px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        ul li {
            font-size: 0.9rem;
            color: var(--text);
            line-height: 1.65;
            margin-bottom: 8px;
            padding-left: 18px;
            position: relative;
        }

        ul li::before {
            content: "•";
            color: var(--bullet-orange);
            font-size: 1.1rem;
            position: absolute;
            left: 0;
            top: -1px;
        }

        /* Signature Block */
        .signature-block {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
            padding-top: 16px;
        }

        .sig-line {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--section-title);
            letter-spacing: 1px;
        }

        .date-line {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--section-title);
            letter-spacing: 1px;
            margin-top: 20px;
            width: 50%;
        }

        .text {
            color: var(--text);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .page {
                border: 3px solid var(--orange);
                box-shadow: none;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

    <!-- PAGE 1 -->
    <div class="page">
        <div class="header">
            <h1>MEMBERSHIP CONTRACT</h1>
            <div class="logo"><img src="{{ asset('img/logo4.png') }}" alt="UBN Logo"></div>
        </div>

        <!-- Attendance Policy -->
        <div class="section">
            <div class="section-title">Attendance Policy</div>
            <p class="section-intro">Members are expected to attend all scheduled meetings.</p>
            <ul>
                <li>Members are allowed 3 absence per six month rotation period.</li>
                <li>In case of a medical emergency, genuine urgency, the demise of a close family member, or the marriage of a member, absence may be approved by the Leadership Team and Support Team. (In such cases, the member will still be required to pay the meeting fees.)</li>
                <li>If a member is unable to attend a meeting, they must send a substitute from their organization or business to represent them. Only 3 substitutes allowed per six month.</li>
                <li>If a member leaves in between a meeting, or is late by 30 minutes on four occasions, it will be considered as an absence.</li>
            </ul>
        </div>

        <!-- Category Exclusivity -->
        <div class="section">
            <div class="section-title">Category Exclusivity</div>
            <ul>
                <li>UBN grants exclusive rights to a member for their specific professional category. Once a category is filled, no other member offering the same services will be allowed to join.</li>
            </ul>
        </div>

        <!-- Code of Conduct -->
        <div class="section">
            <div class="section-title">Code of Conduct</div>
            <ul>
                <li>All members must maintain a high level of professionalism, ethics, and courtesy during UBN meetings and events. Any form of harassment, discrimination, or unprofessional behavior will not be tolerated.</li>
                <li>Members are expected to arrive on time for all meetings and events. Late arrivals may be noted and could affect the membership.</li>
                <li>Members should give constructive feedback and provide referrals in a positive and respectful manner.</li>
            </ul>
        </div>

        <!-- Membership Renewal -->
        <div class="section">
            <div class="section-title">Membership Renewal</div>
            <ul>
                <li>Members are required to pay annual membership dues 60 days in advance, and also need to pay the monthly meeting fees at the beginning of each month.</li>
                <li>Members wishing to renew their membership must have actively participated in meetings, contributed to the network through referrals, and adhered to the UBN policies.</li>
                <li>Renewal is not automatic and will be subject to review by the Membership Committee, followed by approval from the Leadership Team.</li>
            </ul>
        </div>
    </div>

    <!-- PAGE 2 -->
    <div class="page">
        <div class="header">
            <h1>MEMBERSHIP CONTRACT</h1>
            <div class="logo"><img src="{{ asset('img/logo4.png') }}" alt="UBN Logo"></div>
        </div>

        <!-- Conflict Resolution -->
        <div class="section">
            <div class="section-title">Conflict Resolution</div>
            <p class="section-intro">Members are expected to attend all scheduled meetings.</p>
            <ul>
                <li><strong>Internal Disputes:</strong> In case of conflicts between members, a neutral third party from UBN leadership will mediate the issue. All members are expected to resolve conflicts in a professional and respectful manner.</li>
                <li><strong>Policy Violations:</strong> Any violation of UBN policies may result in disciplinary action, including temporary suspension or expulsion from the network.</li>
            </ul>
        </div>

        <!-- Confidentiality -->
        <div class="section">
            <div class="section-title">Confidentiality</div>
            <ul>
                <li><strong>Trust and Discretion:</strong> Members must treat all information shared within UBN, including business plans, referrals, with strict confidentiality. Breaching confidentiality could lead to membership termination.</li>
            </ul>
        </div>

        <!-- Membership Support Letters -->
        <div class="section">
            <div class="section-title">Membership Support Letters</div>
            <ul>
                <li>The Membership Committee may issue up to three support letters to a member in case of policy violations. If the member fails to improve after the third support letter, the Committee will issue a fourth letter of expulsion, and the member's category will be declared open.</li>
            </ul>
        </div>

        <!-- Refund Policy -->
        <div class="section">
            <div class="section-title">Refund Policy</div>
            <ul>
                <li>All membership fees paid to UBN are non-refundable once the membership is activated and member benefits are accessed.</li>
                <li>Memberships are annual and cannot be cancelled mid-term.</li>
                <li>For a new Circle that has not yet launched, once the expectation-setting meeting with 10 members is completed, no refunds will be permitted.</li>
                <li>Memberships are non-transferable.</li>
                <li>No refunds will be provided for any remaining period if a member chooses to discontinue their membership voluntarily.</li>
                <li>In case of expulsion, the member will not be entitled to any refund of membership fees.</li>
            </ul>
        </div>

        <!-- Signature Block -->
        <div class="signature-block">
            <div class="sig-line">NAME :- <strong>{{ $name }}</strong></div>
            <div class="sig-line">SIGN :- <strong>{{ $signature }}</strong></div>
        </div>
        <div class="date-line">DATE :- <strong>{{ $date }}</strong></div>
    </div>

</body>

</html>
