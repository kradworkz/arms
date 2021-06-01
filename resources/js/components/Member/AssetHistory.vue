<<template>
    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
        <table class="table table-nowrap table-centered table-hover mb-0">
            <tbody>
                <tr>
                    <td>
                        <h5 class="text-truncate font-size-14 mb-1"><a href="#" class="text-dark">Skote Saas Dashboard</a></h5>
                        <p class="text-muted mb-0">Assigned to Mark</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                histories: []
            }
        },
        
        created(){
            
        },

        methods : {
            fetch(){
                axios.get(page_url)
                .then(response => {
                    this.histories = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>
