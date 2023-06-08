<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProjects()
    {
        $response = $this->get('/api/projects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'project_name',
                'project_description',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testGetProject()
    {
        $project = factory(\App\Models\Project::class)->create();

        $response = $this->get('/api/projects/' . $project->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $project->id,
            'project_name' => $project->project_name,
            'project_description' => $project->project_description,
            'created_at' => $project->created_at->toISOString(),
            'updated_at' => $project->updated_at->toISOString(),
        ]);
    }

    public function testCreateProject()
    {
        $data = [
            'project_name' => 'New Project',
            'project_description' => 'This is a new project.',
        ];

        $response = $this->post('/api/projects', $data);

        $response->assertStatus(201);
        $response->assertJson([
            'project_name' => $data['project_name'],
            'project_description' => $data['project_description'],
        ]);
    }

    public function testUpdateProject()
    {
        $project = factory(\App\Models\Project::class)->create();

        $data = [
            'project_name' => 'Updated Project',
            'project_description' => 'This project has been updated.',
        ];

        $response = $this->put('/api/projects/' . $project->id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $project->id,
            'project_name' => $data['project_name'],
            'project_description' => $data['project_description'],
            'created_at' => $project->created_at->toISOString(),
            'updated_at' => $project->fresh()->updated_at->toISOString(),
        ]);
    }

    public function testDeleteProject()
    {
        $project = factory(\App\Models\Project::class)->create();

        $response = $this->delete('/api/projects/' . $project->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}

?>
