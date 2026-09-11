<div class="row clearfix">
    <div class="col-sm-4">
        <b>Mail Option</b>
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="mail_option" >
                    <option selected value="1">Send Mail</option>
                    <option value="0">Do not send mail</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <b>Attachment</b>
        <div class="form-group">
            <div class="form-line">
                <input type="file" class="form-control" multiple="multiple" name="file[]" >
            </div>
        </div>
    </div>

     <div class="col-sm-6">
        <b>Copy (cc)</b>
        <div class="form-group">
            <div class="form-line">
                <textarea class="form-control" name="mail_copy" id="copy_mails" placeholder="Enter Email(s), use a comma to separate them" >
                   
                </textarea>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">

    <textarea id="mail_message" name="message" class="ckeditor" placeholder="Message">
         Dear Supplier,

            You are invited to submit your quotation via this ERP portal. Please comply with the instructions below:<br><br>

            1. Submission Method<br>

            Quotations must be submitted exclusively through this ERP system.
            Email submissions will not be accepted.
            2. Compliant Offer<br>

            Where fully compliant with the RFQ specification:<br>

            Enter unit prices against each line item in the ERP pricing fields.<br>
            Enter discount (if any) in the designated field.<br>
            Enter VAT in the designated field.<br>
            Prices entered in the ERP pricing fields constitute your official commercial offer.<br><br>

            3. Alternative / Deviation Offer<br>

            Where proposing an alternative brand, model, or technical deviation:<br>

            Do not complete the ERP pricing fields.
            Upload a signed and dated alternative/deviation quotation on official company letterhead.
            Clearly state all deviations.<br><br>
            

            4. Commercial Information<br>

            Enter the following in the Enter message field:<br><br>

            Payment terms<br>
            Delivery terms (Incoterms - EXW, DDP, FOB, etc.)<br>
            Quotation validity period<br>
            5. Tax<br><br>

            Prices must be exclusive of VAT (VAT entered separately).<br>
            2% WHT will be deducted in accordance with Nigerian tax laws.<br>
            Note: ENG RYPAC LIMITED reserves the right to accept or reject any quotation.<br>
    </textarea>
    <script>
        CKEDITOR.replace('mail_message');
    </script>
</div>