<div>
    <x-table :headers="$headers" :rows="$abonnements" link="/advanced/abonnements/{id}/valider_souscription" :sort-by="$sortBy" striped with-pagination>
        @scope('cell_statut', $abonnement)
            @if ($abonnement->statut == 1)
                <span class="badge badge-success">Payé</span>
            @endif
            @if ($abonnement->statut == 0)
                <span class="badge badge-warning">Non Payé</span>
            @endif
        @endscope

        @scope('cell_is_active', $abonnement)
            @if ($abonnement->is_active == 1)
                <span class="badge badge-success">Actif</span>
            @endif
            @if ($abonnement->is_active == 0)
                <span class="badge badge-warning">En attente</span>
            @endif
            @if ($abonnement->is_active == 2)
                <span class="badge badge-error">Expire</span>
            @endif
        @endscope

    </x-table>
</div>
