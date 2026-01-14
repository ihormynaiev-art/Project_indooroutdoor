$.fn.dataTable.isDataTable("#plans-data")?table=$("#plans-data").DataTable():$("#plans-data").DataTable({ordering:!0,ajax:"plans",columns:[{data:"display_name"},{data:"config",render:function(a,i,n){var e;return((e=a==null?void 0:a.features)==null?void 0:e.max_portfolio_photos)||"N/A"}},{data:"config",render:function(a,i,n){var e;return((e=a==null?void 0:a.limits)==null?void 0:e.lead_delay_hours)||0}},{data:"is_active",type:"boolean",render:function(a,i,n){return a?'<i class="text-success fa-solid fa-circle-check fa-xl"></i>':'<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>'}},{data:"id",orderable:!1,render:function(a,i,n){return`
                        <div class="action-language">
                            <a class="table-edit" href="/admin/plans/${a}/edit">
                                <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                            </a>
                        </div>`}}],paging:!0,searching:!1,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});
