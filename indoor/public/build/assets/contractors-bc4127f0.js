if($.fn.dataTable.isDataTable("#contractors-data"))n=$("#contractors-data").DataTable();else var n=$("#contractors-data").DataTable({ordering:!0,order:[[2,"desc"]],ajax:"contractors",columnDefs:[{width:"20%",targets:0}],columns:[{data:null,render:function(a,e,t){return`<a target="_blank" href="/admin/providerDetail/${a.id}">
                        <span>${a.provider_detail.business_name}</span>
                    </a><br><a target="_blank" href="/admin/homeowners/${a.id}">
                        <span>${a.name}</span>
                    </a>`}},{data:"email"},{data:"created_at"},{data:"is_verified",type:"boolean",render:function(a,e,t){return a?'<i class="text-success fa-solid fa-circle-check fa-xl"></i>':'<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>'}},{data:"provider_detail",render:function(a,e,t){return a&&a.plan?`<span class="badge bg-${a.plan.name==="premium"?"primary":"secondary"}">${a.plan.display_name}</span>`:'<span class="text-muted">-</span>'}},{data:null,orderable:!1,render:function(a,e,t){return`
                    <div class="action-language">
                        <a class="table-page"
                            target="_blank"
                            href="/provider-details/${a.provider_detail.slug}">
                            <i class="fa-regular fa-save"></i><span>Page</span>
                        </a>
                        <a class="table-show" href="/admin/contractors/${a.id}/edit">
                            <i class="fa-regular fa-bookmark"></i><span>Ad</span>
                        </a>
                    </div>
                    <div class="action-language mt-1 mx-1">
                        <a class="table-edit" href="providerDetail/${a.id}">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>

                        <a class="table-delete" href="javascript:void(0);" data-id="${a.id}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`}}],paging:!0,searching:!0,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$("#change-role").on("show.bs.modal",function(a){let e=$(a.relatedTarget),t=e.data("role"),r=$("#role");$(this).find("#id").val(e.data("id")),r.val(t).trigger("change"),t==="super admin"?r.attr("disabled","disabled"):r.attr("disabled",!1)});$("#reply-form").on("submit",function(a){a.preventDefault();var e=$(this),t=e.serialize();let r=$("#id").val();$.ajax({url:`/admin/contractors/${r}/changeRole`,method:"PATCH",data:t,success:function(i){n.ajax.reload(),$("#change-role").modal("hide")},error:function(i,s,o){$("#change-role").modal("hide")}})});$(document).on("click",".table-resposnive .table-delete",function(){var a="Are you sure want to delete?",e=$(this).data("id"),t=$("#auth-user").val();e==t&&(a=a+" After deleting your own account, you will be logged out"),Swal.fire({title:"Delete user",text:a,showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(r=>{r.isConfirmed&&$.ajax({type:"DELETE",url:"contractors/"+e,data:{_method:"DELETE",_token:$("#token").val()},success:function(i){e==t&&(window.location.href="/"),i.status==="success"&&n.ajax.reload()}})})});$(document).ready(function(){$("#nameFilter").on("keyup change",function(){n.column(0).search(this.value).draw()}),$("#emailFilter").on("keyup change",function(){n.column(1).search(this.value).draw()})});
