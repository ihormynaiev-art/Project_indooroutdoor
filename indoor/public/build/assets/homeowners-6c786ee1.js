if($.fn.dataTable.isDataTable("#homeowners-data"))n=$("#homeowners-data").DataTable();else var n=$("#homeowners-data").DataTable({ordering:!0,order:[[3,"desc"]],ajax:"homeowners",columnDefs:[{width:"20%",targets:0},{orderable:!1,targets:4}],columns:[{data:"name"},{data:"email"},{data:"email_verified_at",type:"boolean",render:function(e,t,a){return e?'<i class="text-success fa-solid fa-circle-check fa-xl"></i>':'<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>'}},{data:"created_at"},{data:"id",orderable:!1,render:function(e,t,a){var r=`
                    <div class="action-language">
                        ${(a.roles.length>0?a.roles[0].name:"")==="provider"?`<a class="table-edit" href="providerDetail/${e}">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>`:""}
                        <a class="table-show" href="homeowners/${e}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a class="table-edit" href="homeowners/${e}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${e}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return r}}],paging:!0,searching:!0,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var e="Are you sure want to delete?",t=$(this).data("id"),a=$("#auth-user").val();t==a&&(e=e+" After deleting your own account, you will be logged out"),Swal.fire({title:"Delete user",text:e,showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(o=>{o.isConfirmed&&$.ajax({type:"DELETE",url:"homeowners/"+t,data:{_method:"DELETE",_token:$("#token").val()},success:function(s){t==a&&(window.location.href="/"),s.status==="success"&&n.ajax.reload()}})})});$(document).ready(function(){$("#nameFilter").on("keyup change",function(){n.column(0).search(this.value).draw()}),$("#emailFilter").on("keyup change",function(){n.column(1).search(this.value).draw()})});
