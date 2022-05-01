import AppForm from "../app-components/Form/AppForm";

Vue.component("user-form", {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                class_id: "",
                course_id: "",
            },
        };
    },
});
