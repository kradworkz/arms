<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Map Track</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" style="height: 500px;">
                    <LMap ref="mymap" style="width: 100%; height: 100%;" :zoom="zoom" :center="center">
                        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
                      
                        <LMarker :lat-lng="center"></LMarker>
                    </LMap>
                </div>
            </div>
        </div>
    </div>
</template>

<script> 
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LIcon } from 'vue2-leaflet';
export default {
    props: ['selectedasset'],
    data(){
        return {
            currentUrl: window.location.origin,
            url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 15,
            center: [6.905508,122.075958],
           
            confirmed : [],
            staticAnchor: [16, 37],
            customText: "Foobar",
            iconSize: 64
        }
    },

    computed: {
        dynamicSize() {
            return [this.iconSize, this.iconSize * 1.15];
        },
        dynamicAnchor() {
            return [this.iconSize / 2, this.iconSize * 1.15];
        }
    },

    methods : {
        track(coor){
            this.center = JSON.parse(coor);
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },
        
        trackId(id){
            axios.get(this.currentUrl + '/request/member/coordinates/'+id)
            .then(response => {
                this.center = JSON.parse(response.data.coordinates);
            })
            .catch(err => console.log(err));
            // this.center = JSON.parse(coor);
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },

    },
    components: {
        LMap,
        LTileLayer,
        LMarker, LIcon
    }
}

</script>

