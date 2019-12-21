<template>
    <div class="container">
            <form @submit.prevent="updateCritea">
                <div class="alert alert-info" v-if="statusOfUpdate === 200">
                    {{ updateMsg }}
                </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Critea Name</label>
                <input class="form-control" type="text" v-model="criteasToUpdate.textcriteaName" />
                <span v-if="updateMsg.textcriteaName" class="error"> {{ updateMsg.textcriteaName | trimCharacters }}</span>   
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Percentage</label>
                <input class="form-control" type="text" v-model="criteasToUpdate.textcriteaPercentage" />
                <span v-if="updateMsg.textcriteaPercentage" class="error"> {{ updateMsg.textcriteaPercentage | trimCharacters }}</span> 
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Default Critea Grade</label>
                <input class="form-control" type="text" v-model="criteasToUpdate.defaultCriteaGrade" />
                <span v-if="updateMsg.defaultCriteaGrade" class="error"> {{ updateMsg.defaultCriteaGrade | trimCharacters }}</span> 
            </div>

            <div class="col-md-12 col-lg-12 mt-5">
                <button type="submit" class="btn btn-primary" @click="clearNotification">Update Critea</button>
            </div>
        </form>

    </div>

</template>

<script>
export default {
    props: ['criteaID'],
    data() {
        return {
            criteasToUpdate: {
                textcriteaName: '',
                textcriteaPercentage: '',
                defaultCriteaGrade: ''
            },
            statusOfUpdate: '',
            updateMsg: ''
        }
    },
    created() {
       this.getPropData()
    },

    methods: {
        getPropData() {
            axios.get(`http://localhost:8000/api/managecritea/${this.criteaID}`).then(
                response => {
                this.criteasToUpdate.textcriteaName = response.data[0].critea;
                this.criteasToUpdate.textcriteaPercentage = response.data[0].percentage;
                this.criteasToUpdate.defaultCriteaGrade = response.data[0].defaultGrade;    
            });  
           
        },
        updateCritea() {
            axios.put(`http://localhost:8000/api/managecritea/${this.criteaID}`, this.criteasToUpdate).then(
                response => {
                    this.statusOfUpdate = response.status;
                    this.updateMsg = response.data.original;
                    this.refreshList(response.status);
                    console.log(response.data.original);
                    this.clearTextboxes();
                   
            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.updateMsg = error.response.data.errors;
              
            });
        },
        clearNotification() {
            this.statusOfUpdate = '';
            this.updateMsg = '';
        },
        clearTextboxes() {
            this.criteasToUpdate.textcriteaName = '';
            this.criteasToUpdate.textcriteaPercentage = '';
            this.criteasToUpdate.defaultCriteaGrade = '';
        },
        refreshList(status) {
            this.$emit('refreshList', status);
        }
      
    },
    filters: {
        trimCharacters: function(value) {
            return value.toString();
        }
    }

}
</script>

<style scoped>
.error {
    color:red;
}
</style>