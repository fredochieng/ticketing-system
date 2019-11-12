<div class="pos-tab-content active">
 <div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name">Business Name:*</label>
            <input class="form-control" required="" placeholder="Business Name" name="name" type="text"
                value="" id="name">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input class="form-control start-date-picker" placeholder="Start Date" readonly="" name="start_date"
                    type="text" value="" id="start_date">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="business_logo">Upload Logo:</label>
            <input accept="image/*" name="business_logo" type="file" id="business_logo">
            <p class="help-block"><i> Previous logo (if exists) will be replaced</i></p>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="default_profit_percent">Default interest percent:*</label> <i
                class="fa fa-info-circle text-info hover-q " aria-hidden="true" data-container="body" data-toggle="popover"
                data-placement="auto"
                data-content="Default profit margin of a product. <br><small class='text-muted'>Used to calculate selling price based on purchase price entered.<br/> You can modify this value for indivisual products while adding</small>"
                data-html="true" data-trigger="hover"></i>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-plus-circle"></i>
                </span>
                <input class="form-control" min="0" step="0.01" max="100" name="default_profit_percent" type="number"
                    value="10" id="default_profit_percent">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="fy_start_month">Financial year start month:</label> <i
                class="fa fa-info-circle text-info hover-q " aria-hidden="true" data-container="body"
                data-toggle="popover" data-placement="auto"
                data-content="Starting month of The Financial Year for your business" data-html="true"
                data-trigger="hover"></i>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <select class="form-control select2 select2-hidden-accessible" required="" id="fy_start_month"
                    name="fy_start_month" tabindex="-1" aria-hidden="true">
                    <option value="1" selected="selected">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select><span class="select2 select2-container select2-container--default" dir="ltr"
                    style="width: 230px;"><span class="selection"><span
                            class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true"
                            aria-expanded="false" tabindex="0" aria-labelledby="select2-fy_start_month-container"><span
                                class="select2-selection__rendered" id="select2-fy_start_month-container"
                                title="January">January</span><span class="select2-selection__arrow"
                                role="presentation"><b role="presentation"></b></span></span></span><span
                        class="dropdown-wrapper" aria-hidden="true"></span></span>
            </div>
        </div>
    </div>
</div>
</div>
