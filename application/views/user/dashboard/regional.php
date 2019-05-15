<div class="row" style="padding-left: 10px;padding-right: 10px;">
  <div class="col-sm-12 col-lg-12" id="mapChart" style="height: 400px;"></div>
</div>

<script type="text/javascript">
  var c_region1 = '#00aced';
            var c_region2 = '#004f6e';
            var c_region3 = '#4875b4';
            var c_region4 = '#00c204';
            var c_region5 = '#d38436';
            var c_region6 = '#f396cf';
            var c_region7 = '#96e7f3';

            $('#mapChart').vectorMap({
              map: 'indonesia_id',
              backgroundColor: '#a5bfdd',
              borderColor: '#818181',
              borderOpacity: 0.25,
              borderWidth: 1,
              color: '#f4f3f0',
              enableZoom: true,
              hoverColor: '#c9dfaf',
              hoverOpacity: null,
              normalizeFunction: 'linear',
              scaleColors: ['#b6d6ff', '#005ace'],
              selectedColor: '#c9dfaf',
              selectedRegions: null,
              showTooltip: true,
              onRegionClick: function(element, code, region)
              {

                console.log(this);
                  var message = region;

                  console.log(message);
              },
              pins: <?= json_encode($regional); ?>,
            });

            $('#mapChart').vectorMap('set', 'colors', { path01: c_region1, 
                                                        path02: c_region1,
                                                        path03: c_region1,
                                                        path04: c_region1,
                                                        path05: c_region1,
                                                        path06: c_region1,
                                                        path07: c_region1,
                                                        path08: c_region1,
                                                        path09: c_region1,
                                                        path10: c_region1,
                                                        
                                                        path11: c_region2,
                                                        path14: c_region2,

                                                        path12: c_region3,

                                                        path13: c_region4,
                                                        path16: c_region4,

                                                        path15: c_region5,
                                                        path17: c_region5,
                                                        path18: c_region5,
                                                        path19: c_region5,

                                                        path20: c_region6,
                                                        path21: c_region6,
                                                        path22: c_region6,
                                                        path23: c_region6,
                                                        path24: c_region6,

                                                        path25: c_region7,
                                                        path26: c_region7,
                                                        path27: c_region7,
                                                        path28: c_region7,
                                                        path29: c_region7,
                                                        path30: c_region7,
                                                        path31: c_region7,
                                                        path32: c_region7,
                                                        path33: c_region7,
                                                        path34: c_region7,
                                               

                                                      });
</script>