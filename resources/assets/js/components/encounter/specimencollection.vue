<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary" class="elevation-0">
          <v-toolbar-title>Receive Specimen</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn round outline color="blue lighten-1" flat @click.native="close">
            Cancel
            <v-icon right dark>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm12 md12>
                    <v-select
                      :items="specimenTypes"
                      v-model="specimenCollection.specimen_type_id"
                      overflow
                      item-text="name"
                      item-value="id"
                      label="Specimen Type">
                    </v-select>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      readonly
                      v-model="specimenCollection.time_collected"
                      :rules="[v => !!v || 'Time Collected is Required']"
                      label="Time Collected"
                      @click="datePicker.time_collected = true">
                    </v-text-field>
                    <v-date-picker
                      v-show="datePicker.time_collected"
                      v-model="specimenCollection.time_collected"
                      :landscape="landscape" :reactive="reactive">
                    </v-date-picker>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      readonly
                      v-model="specimenCollection.time_received"
                      :rules="[v => !!v || 'Time Received is Required']"
                      label="Time Received"
                      @click="datePicker.time_received = true">
                    </v-text-field>
                    <v-date-picker
                      v-show="datePicker.time_received"
                      v-model="specimenCollection.time_received"
                      :landscape="landscape" :reactive="reactive">
                    </v-date-picker>
                  </v-flex>
                  <v-flex xs12 sm12 md12>
                    <v-text-field
                      v-model="specimenCollection.collected_by"
                      :rules="[v => !!v || 'Collected by is Required']"
                      label="Collected by">
                    </v-text-field>
                  </v-flex>
                </v-layout>
                Select Relevant Test
                <v-layout row wrap>
                  <v-flex
                  xs6 sm6 md6
                  v-for="test in tests"
                  :key="test.id">
                  <v-checkbox
                    v-model="specimenCollection.testIds"
                    v-if="isSpecimenCompartible(test)"
                    :label="test.test_type.name"
                    :value="test.id"> 
                  </v-checkbox>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="save">
                Save <v-icon right dark>cloud_upload</v-icon>
              </v-btn>
            </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import apiCall from '../../utils/api'
  export default {
    data: () => ({
      datePicker: {
        time_collected: false,
        time_received: false,
      },
      landscape: true,
      reactive: true,
      valid: true,
      dialog: false,
      saving: false,
      specimenTypes: [],
      encounter: {},
      tests: {},
      specimenCollection: {
        encounter_id: '',
        specimen_type_id: '',
        time_collected: '',
        collected_by: '',
        time_received: '',
        testIds: [],
      }
    }),

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
    },

    methods: {

      initialize () {

        apiCall({url: '/api/specimentype', method: 'GET' })
        .then(resp => {
          console.log(resp.data)
          this.specimenTypes = resp.data;
        })
        .catch(error => {
          console.log(error.response)
        })
      },

      isSpecimenCompartible (test) {
        let boolean = false;
          for (var i = test.test_type.specimen_types.length - 1; i >= 0; i--) {
            if (test.test_type.specimen_types[i].id == this.specimenCollection.specimen_type_id) {
              boolean = true
            }
          }
        return boolean;
      },

      modal (encounter) {
        this.tests = encounter.tests;
        this.encounter = encounter;
        this.specimenCollection.encounter_id = encounter.id;
        this.dialog = true;
      },

      close () {
        this.dialog = false
      },

      save () {

        this.saving = true;

        apiCall({url: '/api/encounter/specimencollection', data: this.specimenCollection, method: 'POST' })
        .then(resp => {
          console.log(resp)
          this.saving = false;
        })
        .catch(error => {
          console.log(error.response)
        })

        this.close()
      }
    }
  }
</script>
