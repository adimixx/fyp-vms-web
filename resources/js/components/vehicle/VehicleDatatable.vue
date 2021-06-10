<template>
    <v-server-table
        :url="tableUrl"
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
                    "model",
                    "type",
                    "actions"
                ],
                options: {
                    headings: {
                        reg_no: "Plate Number"
                    }
                }
            }
        };
    },
    props: {
        route: String,
        tableUrl: String
    }
};
</script>

<style></style>
