<template>
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="setcoordinates">
                <div class="modal-body">
                    <div class="col-md-12">
                        <center style="margin-top: 30px; margin-bottom: 30px;">
                            <i class='bx bx-loader bx-flashing bx-rotate-180' style="font-size: 100px;"></i>
                        </center>
                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
            }
        },

        methods : {
            fetch(id){
                
            }
        }
    }
</script>