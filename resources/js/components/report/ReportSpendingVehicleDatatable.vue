<template>
    <v-server-table
        :url="apiUrl"
        :columns="table.columns"
        :options="table.options"
    >
        <template v-slot:actions="props">
            <a class="text-decoration-none" :href="route + '/' + props.row.id">
                <i class="far fa-eye"></i>
            </a>
        </template>
    </v-server-table>
</template>

<script>
export default {
    data() {
        return {
            table: {
                columns: ["spending","number_of_maintenance", "reg_no", "vehicle", "vehicle_category", "actions"],
                options: {
                    headings: {
                        vehicle_category: "Category",
                        reg_no: "Plate Number",
                        number_of_maintenance: "Number of Maintenance"
                    }
                }
            }
        };
    },
    props: {
        route: String,
        apiUrl: String
    }
};
</script>

<style></style>
