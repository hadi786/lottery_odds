<template>
  <div class="main_panel">
    <div class="top_head">
      <v-container>
        <h1 class="text-center py-4 white--text">LOTTERY ODDS</h1>
      </v-container>
    </div>
    <v-container>
      <v-card class="v-card-custom">
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <h2 class="mb-3">Calculate Odds</h2>
              <v-card>
                <v-card-text>
                  <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                  >
                    <v-text-field
                      v-model="balls_main_pool"
                      filled
                      label="Balls Main Pool"
                      dense
                      :rules="mainBallsRules"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="balls_drawn"
                      filled
                      label="Total Balls Drawn"
                      dense
                      :rules="BallsDrawnsRules"
                      required
                    ></v-text-field>
                    <v-btn  class="mr-4 grey darken-3 white--text"  @click="calculate_odds" :disabled="loading" block>Calculate</v-btn>
                  </v-form>
                    <v-img
                    class="my-4"
                      lazy-src="a/images/powerballs.jpg"
                      src="/images/powerballs.jpg"
                  ></v-img>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="8">
              <h2 class="mb-3">Generated Results</h2>
              <v-data-table
                :headers="headers"
                :items="dataSet"
                class="elevation-3"
                :expand="true"
                :loading="loading"
                :footer-props="{
                  'items-per-page-options': [10, 20, 30, 40, -1],
                }"
                :items-per-page="10"
                loading-text="Please wait..."
              >
              </v-data-table>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-container>
  </div>
</template>

<script>
const axios = require("axios").default;

export default {
  data: () => ({
    valid: true,
    mainBallsRules: [
      v => !!v || 'Balls in main pool is required'
    ],
    BallsDrawnsRules: [
      v => !!v || 'Balls Drawn in main pool is required'
    ],
    loading: false,
    headers: [
      { text: "Number Matched", value: "number_matched", sortable: false },
      { text: "Calucated Odds", value: "calucated_odds", sortable: false }
    ],
    dataSet: [],
    balls_main_pool: 48,
    balls_drawn: 6
  }),
  async mounted(){
    await this.calculate_odds()
  },
  methods: {
    async calculate_odds() {
      let validate = this.$refs.form.validate()
      if(validate == true){
        this.loading = true;
        try {
          this.dataSet = [];
          let post_data = {
            "balls_main_pool": this.balls_main_pool,
            "balls_drawn": this.balls_drawn
          }
          let response = await axios.post("http://127.0.0.1:8000/api/results", post_data);
          if(response){
            this.loading = false;
            this.dataSet = response.data;
          }
        } catch (error) {
          console.log(error)
        }
      }
    }
  }
}
</script>