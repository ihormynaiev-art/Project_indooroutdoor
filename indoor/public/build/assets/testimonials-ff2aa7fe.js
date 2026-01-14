if($.fn.dataTable.isDataTable("#testimonials-data"))s=$("#testimonials-data").DataTable();else var s=$("#testimonials-data").DataTable({ordering:!0,ajax:"testimonials",columns:[{data:"nickname"},{data:"email"},{data:"title"},{data:"rating",render:function(a,t,i){if(t==="sort"||t==="type")return a;var e="";for(let n=0;n<a;n++)e=e+'<i class="fas fa-star filled"></i>';return`
                    <div class="rating">
                        ${e}
                    </div>`}},{data:"provider_detail",render:function(a,t,i){return a.business_name}},{data:"id",orderable:!1,render:function(a,t,i){var e=`
                        <div class="action-language">
                            <a class="table-show" href="/admin/testimonials/${a}">
                                <i class="fa-regular fa-eye"></i><span>Show</span>
                            </a>
                            <a class="table-delete" href="javascript:void(0);" data-id="${a}">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                            </a>
                        </div>`;return e}}],paging:!0,searching:!1,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var a=$(this).data("id");Swal.fire({title:"Delete testimonial",text:"Are you sure want to delete?",showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(t=>{t.isConfirmed&&$.ajax({type:"DELETE",url:"testimonials/"+a,data:{_method:"DELETE",_token:$("#token").val()},success:function(i){i.status==="success"&&s.ajax.reload()}})})});
