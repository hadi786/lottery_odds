<template>
<v-container>
  <v-row>
      <v-col cols="12" sm="12" class="px-0">
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
        >
        <v-row>
          <v-col cols="12" sm="12">
            <strong>Calculate Odds <v-icon>mdi-trending-neutral</v-icon></strong>
          </v-col>
          <v-col cols="5" sm="5" class="pb-0">
            <v-text-field
              v-model="balls_main_pool"
              filled
              label="Balls Main Pool"
              dense
              :rules="mainBallsRules"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="5" sm="5" class="pb-0">
            <v-text-field
              v-model="balls_drawn"
              filled
              label="Total Balls Drawn"
              dense
              :rules="BallsDrawnsRules"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="2" sm="2" class="pb-0">
            <v-btn color="primary" class="mr-4 py-6" @click="calculate_odds">Submit</v-btn>
          </v-col>
        </v-row>
        </v-form>
      </v-col>
      <v-col cols="12" sm="12" class="px-0">
         <v-data-table
          :headers="headers"
          :items="dataSet"
          class="elevation-1"
          :expand="true"
          :loading="loading"
          :footer-props="{
            'items-per-page-options': [10, 20, 30, 40, -1],
          }"
          :items-per-page="30"
          loading-text="Please wait..."
        >
         </v-data-table>
      </v-col>
  </v-row>
</v-container>
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
      { text: "Number Matched", value: "number_matched" },
      { text: "Calucated Odds", value: "calucated_odds" }
    ],
    dataSet: [],
    balls_main_pool: 48,
    balls_drawn: 6
  }),
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