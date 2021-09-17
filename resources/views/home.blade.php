<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>League Simulator</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>


    <script src="{{ url(mix('/js/app.js')) }}"></script>
</head>
<body>
<div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div id="app">
        <div class="container container-fluid">
            <div class="col-12">
                <div class="row">
                    <h1 class="text-center">@{{title}}</h1>
                </div>
                <div class="row mt-5">
                    <div class="col-12 col-md-3">
                        <h5 class="fw-bold">Leagues List</h5>

                        <ul class="list-group p-1">
                            <li class="list-group-item list-group-item-action" v-for="league in leagueList">
                                <a class="text-decoration-none" href="javascript:" @click="showLeague(league.id)">
                                    @{{ league.description }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <div class="row" v-if="leagueSelected">
                            <div class="col-12 mb-2">
                                <div class="row justify-content-between">
                                    <div class="col-2">
                                        <button class="btn btn-success" :disabled="isLoading" @click="playAll()">
                                            Play All
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary" :disabled="isLoading" @click="playWeek()">
                                            Play Week
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-danger" :disabled="isLoading" @click="resetLeague()">
                                            @{{ currentWeek ? 'Reset' : 'Initialize' }}
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        <span v-if="isLoading" class="fa fa-spinner fa-spin fa-2x"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="7" class="text-center fw-bolder">
                                            League Table
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            Teams
                                        </th>
                                        <th>
                                            PTS
                                        </th>
                                        <th>
                                            P
                                        </th>
                                        <th>
                                            W
                                        </th>
                                        <th>
                                            D
                                        </th>
                                        <th>
                                            L
                                        </th>
                                        <th>
                                            GD
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="leagueData.league_table.length">
                                    <tr v-for="team in leagueData.league_table">
                                        <td>
                                            @{{ team.name }}
                                        </td>
                                        <td>
                                            @{{ team.points }}
                                        </td>
                                        <td>
                                            @{{ team.played_matches }}
                                        </td>
                                        <td>
                                            @{{ team.winning }}
                                        </td>
                                        <td>
                                            @{{ team.draw }}
                                        </td>
                                        <td>
                                            @{{ team.losing }}
                                        </td>
                                        <td>
                                            @{{ team.goal_difference }}
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="7" class="text-center fw-bold">No Data</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6 table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center fw-bolder">
                                            Match Results
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" v-if="currentWeek && currentWeek.number">
                                            @{{ currentWeek.number }}<sup>@{{ currentWeek.number | ordinal }}</sup>
                                            Week Match Results
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="currentWeek && currentWeek.matches.length">
                                    <tr v-for="match in currentWeek.matches">
                                        <td class="fw-bold text-center">
                                            @{{ match.description }}
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td class="text-center fw-bold">No Data</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6 table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="text-center fw-bolder">
                                            Winning Predictions
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center" v-if="currentWeek && currentWeek.number">
                                            @{{ currentWeek.number }}<sup>@{{ currentWeek.number | ordinal }}</sup>
                                            Week Predictions of Championship
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="leagueData.predictions.length">
                                    <tr v-for="prediction in leagueData.predictions">
                                        <td class="fw-bold text-center">
                                            @{{ prediction.team }}
                                        </td>
                                        <td class="fw-bold text-center">
                                            @{{ prediction.prediction }}%
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td class="text-center fw-bold">No Data</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-else>
                            <h3 class="text-center">Please Select a League</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                title: 'League Simulator',
                leagueSelected: false,
                leagueList: [],
                leagueData: {
                    league: {},
                    league_table: [],
                    schedule: [],
                    predictions: []
                },
                currentWeek: undefined,
                isLoading: false
            }
        },
        mounted() {
            this.getLeadList();
        },
        methods: {
            getLeadList() {
                this.isLoading = true;
                this.$axios.get('api/leagues').then((res) => {
                    this.leagueList = res.data.data;
                    this.isLoading = false;
                });
            },
            showLeague(id) {
                this.leagueSelected = id;
                this.isLoading = true;
                this.$axios.get(`api/leagues/${id}`).then((res) => {
                    this.leagueData = res.data.data;
                    this.currentWeek = this.leagueData.schedule.filter((week) => week.played == 1).pop();
                    if (!this.currentWeek) {
                        this.currentWeek = this.leagueData.schedule[0];
                    }
                    this.isLoading = false;
                });
            },

            playAll() {
                this.isLoading = true;
                this.$axios.post(`api/leagues/${this.leagueSelected}/play_all`).then(() => {
                    this.showLeague(this.leagueSelected);
                });
            },

            playWeek() {
                this.isLoading = true;
                this.$axios.post(`api/leagues/${this.leagueSelected}/play_week`).then(() => {
                    this.showLeague(this.leagueSelected);
                });
            },

            resetLeague() {
                this.isLoading = true;
                this.$axios.post(`api/leagues/${this.leagueSelected}/init`).then(() => {
                    this.showLeague(this.leagueSelected);
                });
            }
        }
    });
</script>
</body>
</html>
