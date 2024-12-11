// Função para buscar os dados da API
function fetchData() {
    $.get('/api/data', function(data) {
        updateTable(data);
        updateChart(data);
    }).fail(function() {
        alert('Erro ao carregar dados.');
    });
}

// Função para atualizar a tabela com os dados
function updateTable(data) {
    const tableBody = $('#dataTable tbody');
    tableBody.empty();
    
    data.forEach(item => {
        const row = `<tr>
            <td>${item.Nome}</td>
            <td>${item.Valor}</td>
            <td>${item.Status}</td>
        </tr>`;
        tableBody.append(row);
    });
}

// Função para atualizar o gráfico
function updateChart(data) {
    const ctx = document.getElementById('myChart').getContext('2d');
    const labels = data.map(item => item.Nome);
    const values = data.map(item => item.Valor);

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valores',
                data: values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Função para buscar e filtrar dados
$(document).ready(function() {
    // Atualiza a cada 15 minutos
    setInterval(fetchData, 15 * 60 * 1000);
    
    // Carregar os dados inicialmente
    fetchData();
    
    // Filtragem de dados na tabela
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#dataTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
