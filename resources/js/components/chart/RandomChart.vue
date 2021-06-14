<template>
  <div class="row">
    <div v-if="children && categories" class="col-lg-12">
      <div class="card">
        <div class="card-header">Generate Chart</div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-3">
              <div class="form-group mb-3">
                <label for="child" class="form-label">Child</label>
                <select v-model="formChart.child_hash" class="form-control" name="child" id="child">
                  <option :value="null">Select...</option>
                  <option v-for="child in children" :value="child.hash" :key="`${child.id}-${child.first_name}`">
                    {{child.first_name}} {{child.last_name}}
                  </option>
                </select>
              </div>
            </div>

              <div class="col-lg-3">
                <div class="form-group mb-3">
                  <label for="category" class="form-label">Category</label>
                  <select v-model="selectedCategory" @change="formChart.category = null" class="form-control" name="child" id="child">
                    <option :value="null">Select</option>
                    <option v-for="(category, index) in categories" :key="index" :value="index">
                      {{index}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group mb-3">
                  <label for="category" class="form-label">Subcategory</label>
                  <select v-model="formChart.category_id" class="form-control" name="child" id="child">
                    <option :value="null">Select</option>
                    <option v-for="option in selectedCategoryOptions" :key="option.id + option.name" :value="option.id">
                      {{option.name}}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group mb-3"> 
                  <label for="birthday" class="form-label">Date Range</label>
                  <br>
                  <!-- <input v-model="formChild.birthday" type="text" class="form-control" id="birthday"> -->
                  <v-date-picker ref="datePickerRange" :timezone="$browserTimezone" is-range v-model="formChart.date_range" />
                </div>
              </div>

              <div class="col-lg-12">
                <button @click="getChartData()">Generate</button>
              </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <canvas id="myChart"></canvas>
    </div>
  </div>
</template>

<script>
  import childrenMixin from '../../mixins/children';
  import categoriesMixin from '../../mixins/categories';

  export default {
    data () {
      return {
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

    methods: {
      getChartData() {
        const hash = this.formChart.child_hash;
        const categoryId = this.formChart.category_id;
        const startDate = Vue.prototype.$dateToMySQL(this.formChart.date_range.start);
        const endDate = Vue.prototype.$dateToMySQL(this.formChart.date_range.end);

        console.log(`${Vue.prototype.$baseAPI}/chart/${hash}/${categoryId}/${startDate}/${endDate}`);

        axios.get(`${Vue.prototype.$baseAPI}/chart/${hash}/${categoryId}/${startDate}/${endDate}`)
          .then(res => {
            this.buildChart(
              res.data.category.group + ' - ' + res.data.category.name, 
              res.data.labels, 
              res.data.data
            );
          })
          .catch(err => {
            this.$toaster.error('Whoops! Could not load chart data');
          })
      },

      buildChart(header, labels, dataEntries) {
        var ctx = document.getElementById('myChart').getContext('2d');

      const config = {
        type: 'line',
        data,
        options: {}
      };

      // const labels = [
      //   'January',
      //   'February',
      //   'March',
      // ];

      const data = {
        labels: labels,
        datasets: [{
          label: header,
          backgroundColor: '#b082fc',
          borderColor: '#7c45d6',
          data: dataEntries,
        }]
      };

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
      },

      getRandomInt () {
        return Math.floor(Math.random() * (50 - 5 + 1)) + 5
      }
    },

    mounted () {
      this.getChildren();
      this.getCategories();
      // this.getChartData();
      // this.buildChart();
    },
    
  }
</script>

<style>
  .small {
    max-width: 600px;
    margin:  150px auto;
  }
</style>