<div class="row">
    <div class="col-12">
        <div class="tab-sets mb-4">
            <div class="tab-contents-sets">
                <ul>
                    <li>
                        <a class="{{ Request::is('admin/plugins-manager') ? 'active' : '' }}"
                            href="{{ url('admin/plugins-manager') }}">Installed Plugins</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/available-plugins') ? 'active' : '' }}"
                            href="{{ url('admin/available-plugins') }}">Available Plugins</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
