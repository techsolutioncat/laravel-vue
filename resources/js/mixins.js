const _mixin = {
    methods: {
        latlng2Dms: function(lat, lng){
            var convertLat = Math.abs(lat);
            var LatDeg = Math.floor(convertLat);

            var LatMin = (Math.floor((convertLat - LatDeg) * 60));
            var LatSec = (convertLat - LatDeg) * 60 - LatMin;
            LatSec = Math.round(LatSec * 100) /100
            var LatCardinal = ((lat > 0) ? "N" : "S");
                
            var convertLng = Math.abs(lng);
            var LngDeg = Math.floor(convertLng);
            var LngMin = (Math.floor((convertLng - LngDeg) * 60));
            var LngSec = (convertLng - LngDeg) * 60 - LngMin;
            LngSec = Math.round(LngSec * 100) / 100;
            var LngCardinal = ((lng > 0) ? "E" : "w");
            // 36°11'22.7"N 137°49'41.7"E
            return LatDeg + '°' + LatMin + '\'' + LatSec + '"' + LatCardinal + 
                " " + LngDeg + '°' + LngMin + '\'' + LngSec + '"' + LngCardinal;
        }
    }
}
export default _mixin;