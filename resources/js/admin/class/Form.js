import AppForm from '../app-components/Form/AppForm';

Vue.component('class-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});