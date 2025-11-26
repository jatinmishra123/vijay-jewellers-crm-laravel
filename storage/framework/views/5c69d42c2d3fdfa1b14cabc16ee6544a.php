<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Receipt</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            padding: 20px 25px;
            border: 1px solid #bbb;
        }

        /* ================= HEADER ================= */
        .company-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-header h1 {
            margin: 0;
            color: #b8860b;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .company-header .sub-text {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .company-header hr {
            border: 0;
            border-top: 2px solid #b8860b;
            margin-top: 5px;
        }

        /* Titles */
        .section-title {
            font-weight: bold;
            font-size: 13px;
            border-bottom: 1px dashed #999;
            margin: 12px 0 5px 0;
        }

        .label {
            font-weight: bold;
            width: 130px;
            display: inline-block;
        }

        .photo {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border: 1px solid #bbb;
            border-radius: 4px;
        }

        .signature-line {
            border-top: 1px solid #444;
            width: 100%;
            margin-top: 25px;
        }

        .tiny {
            font-size: 9px;
            text-align: center;
            margin-top: 3px;
        }

        /* Description small text */
        .desc-box {
            font-size: 10px;
            background: #fff8d5;
            padding: 8px;
            border: 1px solid #e8d8a8;
            margin-top: 8px;
            border-radius: 3px;
            line-height: 1.4;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- ================= COMPANY HEADER ================= -->
    <div class="company-header">
        <h1>VIJAY JEWELLERS</h1>

        <div class="sub-text">Address – 6-1-84, MAIN ROAD, DEODURGA, Karnataka, 584111
</div>
        <div class="sub-text">Contact: +91 99169 51515 • Email: vijayabharana78@gmail.com</div>

        <hr>
    </div>

    <!-- Receipt subtitle -->
    <div style="text-align:center; margin-bottom:8px;">
        <strong>Customer Scheme Receipt</strong><br>
        <small>(System Generated Document)</small>
    </div>

    <!-- PHOTO -->
    <div style="text-align:right; margin-bottom:10px;">
        <img src="<?php echo e($s->profile_image ? public_path('storage/'.$s->profile_image) : public_path('default-user.png')); ?>" class="photo">
    </div>

    <!-- ================= DESCRIPTION ================= -->
    <div class="desc-box">
        This receipt is issued by Vijay Jewellers confirming the registration of the customer 
        under the selected monthly gold savings scheme. Please keep this receipt safe for 
        future reference. For any query regarding payments, scheme details or redemption, 
        kindly contact our support team.
    </div>


    <!-- ================= PERSONAL DETAILS ================= -->
    <div class="section-title">Personal Details</div>

    <table width="100%">
        <tr>
            <td width="50%">
                <div class="label">First Name:</div> <?php echo e($s->first_name); ?> <br>
                <div class="label">Father Name:</div> <?php echo e($s->father_name); ?> <br>
                <div class="label">Aadhar No:</div> <?php echo e($s->aadhar_number); ?>

            </td>

            <td width="50%">
                <div class="label">Last Name:</div> <?php echo e($s->last_name); ?> <br>
                <div class="label">Mobile:</div> <?php echo e($s->mobile_number); ?> <br>
                <div class="label">PAN No:</div> <?php echo e($s->pan_number); ?>

            </td>
        </tr>
    </table>

    <!-- ================= ADDRESS ================= -->
    <div class="section-title">Address</div>

    <table width="100%">
        <tr>
            <td width="50%">
                <div class="label">City / Village:</div> <?php echo e($s->city_village); ?> <br>
                <div class="label">Country:</div> <?php echo e($s->country); ?>

            </td>

            <td width="50%">
                <div class="label">State:</div> <?php echo e($s->state); ?>

            </td>
        </tr>
    </table>

    <!-- ================= SCHEME DETAILS ================= -->
    <div class="section-title">Scheme Details</div>

    <table width="100%">
        <tr>
            <td width="50%">
                <div class="label">Scheme Name:</div> <?php echo e($s->scheme_name); ?> <br>
                <div class="label">EMI Amount:</div> <?php echo e($s->scheme_emi_amount); ?>

            </td>

            <td width="50%">
                <div class="label">EMI Plan:</div> <?php echo e($s->scheme_emi_plan); ?> Months <br>
                <div class="label">Nominee:</div> <?php echo e($s->nominee_name); ?> <br>
                <div class="label">Relation:</div> <?php echo e($s->nominee_relation); ?>

            </td>
        </tr>
    </table>

    <!-- ================= SIGNATURE ================= -->
    <table width="100%" style="margin-top:25px;">
        <tr>
            <td width="50%" style="text-align:center;">
                <div class="signature-line"></div>
                <div class="tiny">Customer Signature</div>
            </td>

            <td width="50%" style="text-align:center;">
                <div class="signature-line"></div>
                <div class="tiny">Authorized Signature</div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>
<?php /**PATH C:\Users\LENOVO\Downloads\vijay_jwellers\resources\views/admin/manage/pdf_report.blade.php ENDPATH**/ ?>