<template>
  <div class="row">
    <div v-if="children && categories" class="col-lg-12 mb-4">
      <div class="card">
        <div class="card-header">Generate Chart</div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-2">
              <div class="form-group mb-3" :class="{'form-group--error': $v.formChart.child_hash.$error}">
                <label for="child" class="form-label">Child</label> <required/>
                <select v-model="formChart.child_hash" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                  <option v-for="child in children" :value="child.hash" :key="`${child.id}-${child.first_name}`">
                    {{child.first_name}} {{child.last_name}}
                  </option>
                </select>
              </div>
            </div>

              <div class="col-lg-2">
                <div class="form-group mb-3" :class="{'form-group--error': $v.formChart.$dirty && !selectedCategory}">
                  <label for="category" class="form-label">Category</label> <required/>
                  <select v-model="selectedCategory" @change="formChart.category = null;formChart.category_id = null;" class="form-control" name="child" id="child">
                    <option :value="null">Select</option>
                    <option v-for="(category, index) in categories" :key="index" :value="index">
                      {{index}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group mb-3" :class="{'form-group--error': $v.formChart.category_id.$error}">
                  <label for="category" class="form-label">Subcategory</label> <required/>
                  <select v-model="formChart.category_id" class="form-control" name="child" id="child">
                    <option :value="null">Select</option>
                    <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option.id">
                      {{option.name}}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group mb-3" :class="{'form-group--error': $v.formChart.date_range.start.$error}"> 
                  <label for="birthday" class="form-label">Date Start</label> <required/>
                  <br>
                  <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                  <v-date-picker v-model="formChart.date_range.start" ref="datePickerRange" :timezone="$browserTimezone">
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </v-date-picker>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group mb-3" :class="{'form-group--error': $v.formChart.date_range.end.$error}"> 
                  <label for="birthday" class="form-label">Date End</label> <required/>
                  <br>
                  <!-- <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" /> -->
                  <v-date-picker v-model="formChart.date_range.end" ref="datePickerRange" :timezone="$browserTimezone">
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </v-date-picker>
                </div>
              </div>

              <div class="col-lg-2 text-center" style="margin-top: 31px;">
                <button class="btn btn-primary width-100" @click="getChartData()">
                  Generate
                </button>
              </div>
            
          </div>
        </div>
      </div>
    </div>
    
      <div v-show="isChartLoaded && chartData.category.tracker_entries.length > 0" class="col-lg-3">
        <card-with-toggle v-if="chartData" cardHeader="Details" :expanded="true" class="mb-4">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Total Entries</td>
                <td class="text-right">{{chartData.entry_count}}</td>
              </tr>
              <tr>
                <td>Total Amount</td>
                <td class="text-right">{{chartData.entry_total_value}}</td>
              </tr>
              <tr>
                <td>Average Amount</td>
                <td class="text-right">{{$wholeOrDecimal(chartData.entry_total_value / chartData.entry_count)}}</td>
              </tr>
              <tr>
                <td>Lowest Amount</td>
                <td class="text-right">{{chartData.data.minGreaterThanZero()}}</td>
              </tr>
              <tr>
                <td>Highest Amount</td>
                <td class="text-right">{{chartData.data.max()}}</td>
              </tr>
            </tbody>
          </table>
        </card-with-toggle>
      </div>
      <div v-show="isChartLoaded && chartData.category.tracker_entries.length > 0" class="col-lg-9">
        <div class="card">
          <div class="card-header" v-if="chartData">
            {{chartData.category.group}} - {{chartData.category.name}}
          </div>
          <div class="card-body" id="chart-container">
            <canvas id="myChart"></canvas>
          </div>
        </div>
      </div>
    
    <transition name="fade">
      <div v-if="chartData && chartData.category.tracker_entries.length === 0" class="col-lg-12 text-center">
        <div class="alert alert-secondary ">The options above does not include any entries. A chart will be generated once entries exist.</div>
      </div>
    </transition>
  </div>
</template>

<script>
  import childrenMixin from '../../mixins/children';
  import categoriesMixin from '../../mixins/categories';

  import { required } from 'vuelidate/lib/validators';

  export default {
    data () {
      return {
        isChartLoaded: false,

        chartData: null,

        formChart: {
          child_hash: null,
          category: null,
          category_id: null,
          date_range: {
            start: null,
            end: null
          }
        }
      }
    },

    mixins: [
      childrenMixin,
      categoriesMixin
    ],

    validations: {
      formChart: {
          child_hash: {
            required
          },
          category_id: {
            required
          },
          date_range: {
            start: {
              required
            },
            end: {
              required
            }
          }
        }
    },

    methods: {
      /**
       * Fetches the chart and report data and generates the chart graphic.
       */
      getChartData() {
        this.$v.formChart.$touch();

        if (!this.$v.formChart.$invalid) {
          this.isChartLoaded = false;

          let oldChart = document.getElementById('myChart');
          if (oldChart) {
            document.getElementById('myChart').remove();
          }

          let newCanvas = document.createElement("canvas");
          newCanvas.id = 'myChart';
          document.getElementById('chart-container').appendChild(newCanvas);  

          const hash = this.formChart.child_hash;
          const categoryId = this.formChart.category_id;
          const startDate = Vue.prototype.$dateToMySQL(this.formChart.date_range.start);
          const endDate = Vue.prototype.$dateToMySQL(this.formChart.date_range.end);

          console.log(`${Vue.prototype.$baseAPI}/chart/${hash}/${categoryId}/${startDate}/${endDate}`);

          axios.get(`${Vue.prototype.$baseAPI}/chart/${hash}/${categoryId}/${startDate}/${endDate}`)
            .then(res => {
              this.chartData = res.data;

              this.buildChart(
                res.data.category.group + ' - ' + res.data.category.name, 
                res.data.labels, 
                res.data.data
              );
              this.isChartLoaded = true;
            })
            .catch(err => {
              this.$toaster.error('Whoops! Could not load chart data');
            })
        } else {
          this.$toasted.error('Please fill out all the fields.');
        }
        
      },

      /**
       * Builds the chart based on the passed in data.
       */
      buildChart(header, labels, dataEntries) {
        var ctx = document.getElementById('myChart').getContext('2d');

      const config = {
        type: 'line',
        data,
        options: {}
      };

      const data = {
        labels: labels,
        datasets: [{
          label: header,
          backgroundColor: '#b082fc',
          borderColor: '#7c45d6',
          data: dataEntries,
        }]
      };

      var delayed;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
          animation: {
            onComplete: () => {
              delayed = true;
            },
            delay: (context) => {
              let delay = 0;
              if (context.type === 'data' && context.mode === 'default' && !delayed) {
                delay = context.dataIndex * 300 + context.datasetIndex * 100;
              }
              return delay;
            },
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
      },
    },

    /**
     * On component mount.
     */
    mounted () {
      this.getChildren();
      this.getCategories();
    },
    
  }
</script>

<style>
  .small {
    max-width: 600px;
    margin:  150px auto;
  }
</style>