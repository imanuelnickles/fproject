/*
     * DONUT CHART
     * -----------
     */

    
      $.plot('#donut-chart', donutData, {
        series: {
          pie: {
            show       : true,
            radius     : 1,
            innerRadius: 0.5,
            label      : {
              show     : true,
              radius   : 2 / 3,
              formatter: labelFormatter,
              threshold: 0.1
            }
    
          }
        },
        legend: {
          show: false
        }
      });
      
      /*
       * Custom Label formatter
       * ----------------------
       */
      function labelFormatterPercent(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
          + label
          + '<br>'
          + Math.round(series.percent) + '%</div>'
      }

      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
          + label
          + '<br>'
          + series.data[0][1] + '</div>'
      }
    
      /*
        * END DONUT CHART
        */