<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UBN Membership Contract</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #E85320; 
            padding: 30px 20px;
            color: #222;
        }

        .page {
            background-color: #E85320;
             min-height: 100vh; 
            max-width: 780px;
            margin: 0 auto 0 auto;
            display: flex;
    		justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 18px;
            padding: 36px 40px 40px 40px;
        }

        /* ── Header ── */
        .header {
          /*  display: flex; */
            align-items: center;
            /* justify-content: space-between; */
            margin-bottom: 32px;
        }

        .header h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #1d3268;
            letter-spacing: 0.5px;
        }

        /* Logo */
        .logo {
           /* margin-left: auto;*/
            /* 🔥 pushes logo to right */
        }

        .logo img {
            height: 70px;
            width: auto;
        }


        /* ── Section Heading ── */
        .section-title {
            font-size: 17px;
            font-weight: 900;
            color: #E85320;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
            margin-top: 22px;
        }

        /* ── Body text ── */
        .section-intro {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        ul {
            list-style: disc;
            padding-left: 22px;
            margin-bottom: 4px;
        }

        ul li {
            font-size: 16px;
            color: #333;
            margin-bottom: 7px;
            line-height: 1.55;
            font-weight: 500;
        }

        /* ── Signature Block ── */
        .signature-block {
            display: flex;
            justify-content: space-between;
            margin-top: 44px;
        }

        .sig-date {
            margin-top: 18px;
        }

        .sig-item {
            font-size: 16px;
            font-weight: 900;
            color: #E85320;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ── Print / PDF styles ── */
        @media print {
            body {
                background-color: #E85320 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 0;
                margin: 0;
            }

            .page {
                margin: 0;
                padding: 24px;
                page-break-after: always;
                min-height: 100vh;          /* 🔥 fill full screen */
                display: flex;
                justify-content: center;

            }

            .page:last-child {
                page-break-after: avoid;
            }

            .card {
                border-radius: 18px !important;
            }

            .no-print {
                display: none !important;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }

        /* Print button */
        .print-bar {
            text-align: center;
            margin-bottom: 22px;
        }

        .btn-print {
            background: #fff;
            color: #E85320;
            border: 2px solid #fff;
            padding: 11px 32px;
            font-size: 14px;
            font-weight: 800;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Nunito', Arial, sans-serif;
            letter-spacing: 0.5px;
            transition: background 0.2s, color 0.2s;
        }

        .btn-print:hover {
            background: #c94010;
            color: #fff;
            border-color: #c94010;
        }
    </style>
</head>

<body>
    <!-- ══════════════ PAGE 1 ══════════════ -->
    <div class="page">
        <div class="card">

           <div class="header">
              <table width="100%">
                  <tr>
                      <td style="font-size:28px; font-weight:800; color:#1d3268;">
                          MEMBERSHIP CONTRACT
                      </td>
                      <td style="text-align:right;">
                          <img src="{{ public_path('img/logo4.png') }}" height="60">
                      </td>
                  </tr>
              </table>
          </div>

            <!-- ATTENDANCE POLICY -->
            <div class="section-title">Attendance Policy</div>
            <p class="section-intro">Members are expected to attend all scheduled meetings.</p>
            <ul>
                <li>Members are allowed 3 absence per six month rotation period.</li>
                <li>In case of a medical emergency, genuine urgency, the demise of a close family member, or the marriage of a member, absence may be approved by the Leadership Team and Support Team. (In such cases, the member will still be required to pay the meeting fees.)</li>
                <li>If a member is unable to attend a meeting, they must send a substitute from their organization or business to represent them. Only 3 substitutes allowed per six month.</li>
                <li>If a member leaves in between a meeting, or is late by 30 minutes on four occasions, it will be considered as an absence.</li>
            </ul>

            <!-- CATEGORY EXCLUSIVITY -->
            <div class="section-title">Category Exclusivity</div>
            <ul>
                <li>UBN grants exclusive rights to a member for their specific professional category. Once a category is filled, no other member offering the same services will be allowed to join.</li>
            </ul>

            <!-- CODE OF CONDUCT -->
            <div class="section-title">Code of Conduct</div>
            <ul>
                <li>All members must maintain a high level of professionalism, ethics, and courtesy during UBN meetings and events. Any form of harassment, discrimination, or unprofessional behavior will not be tolerated.</li>
                <li>Members are expected to arrive on time for all meetings and events. Late arrivals may be noted and could affect the membership.</li>
                <li>Members should give constructive feedback and provide referrals in a positive and respectful manner.</li>
            </ul>

            <!-- MEMBERSHIP RENEWAL -->
            <div class="section-title">Membership Renewal</div>
            <ul>
                <li>Members are required to pay annual membership dues 60 days in advance, and also need to pay the monthly meeting fees at the beginning of each month.</li>
                <li>Members wishing to renew their membership must have actively participated in meetings, contributed to the network through referrals, and adhered to the UBN policies.</li>
                <li>Renewal is not automatic and will be subject to review by the Membership Committee, followed by approval from the Leadership Team.</li>
            </ul>

        </div>
    </div>

    <!-- ══════════════ PAGE 2 ══════════════ -->
    <div class="page">
        <div class="card">

            <div class="header">
              <table width="100%">
                  <tr>
                      <td style="font-size:28px; font-weight:800; color:#1d3268;">
                          MEMBERSHIP CONTRACT
                      </td>
                      <td style="text-align:right;">
                          <img src="{{ public_path('img/logo4.png') }}" height="60">
                      </td>
                  </tr>
              </table>
          </div>
            <!-- CONFLICT RESOLUTION -->
            <div class="section-title">Conflict Resolution</div>
            <p class="section-intro">Members are expected to attend all scheduled meetings.</p>
            <ul>
                <li><strong>Internal Disputes:</strong> In case of conflicts between members, a neutral third party from UBN leadership will mediate the issue. All members are expected to resolve conflicts in a professional and respectful manner.</li>
                <li><strong>Policy Violations:</strong> Any violation of UBN policies may result in disciplinary action, including temporary suspension or expulsion from the network.</li>
            </ul>

            <!-- CONFIDENTIALITY -->
            <div class="section-title">Confidentiality</div>
            <ul>
                <li><strong>Trust and Discretion:</strong> Members must treat all information shared within UBN, including business plans, referrals, with strict confidentiality. Breaching confidentiality could lead to membership termination.</li>
            </ul>

            <!-- MEMBERSHIP SUPPORT LETTERS -->
            <div class="section-title">Membership Support Letters</div>
            <ul>
                <li>The Membership Committee may issue up to three support letters to a member in case of policy violations. If the member fails to improve after the third support letter, the Committee will issue a fourth letter of expulsion, and the member's category will be declared open.</li>
            </ul>

            <!-- REFUND POLICY -->
            <div class="section-title">Refund Policy</div>
            <ul>
                <li>All membership fees paid to UBN are non-refundable once the membership is activated and member benefits are accessed.</li>
                <li>Memberships are annual and cannot be cancelled mid-term.</li>
                <li>For a new Circle that has not yet launched, once the expectation-setting meeting with 10 members is completed, no refunds will be permitted.</li>
                <li>Memberships are non-transferable.</li>
                <li>No refunds will be provided for any remaining period if a member chooses to discontinue their membership voluntarily.</li>
                <li>In case of expulsion, the member will not be entitled to any refund of membership fees.</li>
            </ul>

            <!-- Signature Block -->
            <div class="signature-block">
                <div class="sig-item">Name :- <stronge>{{ $name }}</stronge></div>
                <div class="sig-item">Sign :- <strong>{{ $signature }}</strong></div>
            </div>
            <div class="sig-date">
                <div class="sig-item">Date :- <strong>{{ $date }}</strong></div>
            </div>

        </div>
    </div>

</body>

</html>
