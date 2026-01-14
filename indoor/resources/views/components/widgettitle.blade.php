<div class="row">
    <div class="col-md-6">
        <div class="widget-title">
            <h4>Subscription</h4>
        </div>
    </div>
    <div class="col-md-6 text-md-end">
        <ul class="subs-list">
            <li>
                <a href="{{ url('provider-subscription') }}"
                    class="{{ Request::is('provider-subscription') ? 'active' : '' }}">Plan & Pricing</a>
            </li>
            <li>
                <a href="{{ url('provider-addons') }}"
                    class="{{ Request::is('provider-addons') ? 'active' : '' }}">Addons</a>
            </li>
        </ul>
    </div>
</div>
