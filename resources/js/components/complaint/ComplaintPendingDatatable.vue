<template>
    <v-server-table
        url="/api/datatable/complaint-pending"
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
                    "name",
                    "reg_no",
                    "model",
                    "status",
                    "actions"
                ],
                options: {
                    headings: {
                        name: "Issue",
                        reg_no: "Plate Number"
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
