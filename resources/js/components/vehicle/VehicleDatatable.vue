<template>
    <v-server-table
        url="/api/datatable/vehicle"
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
                columns: [
                    "reg_no",
                    "vehicle_catalog.name",
                    "vehicle_catalog.vehicle_category.name",
                    "actions"
                ],
                options: {
                    headings: {
                        reg_no: "Plate Number",
                        "vehicle_catalog.name": "Model",
                        "vehicle_catalog.vehicle_category.name": "Type"
                    }
                }
            }
        };
    },
    props: {
        route: String
    }
};
</script>

<style></style>
