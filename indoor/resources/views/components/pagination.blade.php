@if (
    !Route::is([
        'customer-booking',
        'customer-favourite',
        'customer-reviews',
        'provider-services',
        'provider-booking',
        'provider-reviews',
        'provider-services-list',
    ]))
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link page-prev" href="javascript:;" tabindex="-1"><i
                        class="fa-solid fa-arrow-left me-1"></i> PREV</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="javascript:;">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:;">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:;">3</a>
            </li>
            <li class="page-item">
                <a class="page-link page-next" href="javascript:;">NEXT <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </li>
        </ul>
    </nav>
@endif
@if (Route::is([
        'customer-booking',
        'customer-favourite',
        'customer-reviews',
        'provider-services',
        'provider-booking',
        'provider-reviews',
        'provider-services-list',
    ]))
    <!-- Pagination -->
    <div class="row">
        <div class="col-sm-6">
            <div class="review-entries">
                <span>Show</span>
                <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span>entries</span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="review-pagination">
                <p>1 - 5 of 10</p>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="javascript:;">1</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:;">2 <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:;">3</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Pagination -->
@endif
