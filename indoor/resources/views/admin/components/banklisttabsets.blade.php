<div class="row">
    <div class="col-12">
        <div class="tab-sets">
            <div class="tab-contents-sets">
                <ul>
                    <li>
                        <a class="{{ Request::is('admin/banktransferlist') ? 'active' : '' }}"
                            href="{{ url('admin/banktransferlist') }}">All List</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/approved-transferlist') ? 'active' : '' }}"
                            href="{{ url('admin/approved-transferlist') }}">Approved </a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/pending-transferlist') ? 'active' : '' }}"
                            href="{{ url('admin/pending-transferlist') }}">Pending </a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/successful-transferlist') ? 'active' : '' }}"
                            href="{{ url('admin/successful-transferlist') }}">Successful </a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/rejected-transferlist') ? 'active' : '' }}"
                            href="{{ url('admin/rejected-transferlist') }}">Rejected lists</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
