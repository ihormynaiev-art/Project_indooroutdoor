<div class="row">
    <div class="col-12">
        <div class="tab-sets mb-4">
            <div class="tab-contents-sets">
                <ul>
                    <li>
                        <a class="{{ Request::is('admin/all-blog') ? 'active' : '' }}"
                            href="{{ url('admin/all-blog') }}">Active Blog</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/pending-blog') ? 'active' : '' }}"
                            href="{{ url('admin/pending-blog') }}">Pending Blog</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('admin/inactive-blog') ? 'active' : '' }}"
                            href="{{ url('admin/inactive-blog') }}">Inactive Blog</a>
                    </li>
                </ul>
            </div>
            <div class="tab-contents-count">
                <h6>Showing 8-10 of 84 results</h6>
            </div>
        </div>
    </div>
</div>
