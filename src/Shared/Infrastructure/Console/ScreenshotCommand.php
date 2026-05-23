<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Console;

require_once __DIR__ . "./../../../../var/grpc/Screenshot/ScreenshotServiceClient.php";
require_once __DIR__ . "./../../../../var/php/Screenshot/CaptureRequest.php";
require_once __DIR__ . "./../../../../var/php/Screenshot/CaptureResponse.php";
require_once __DIR__ . "./../../../../var/php/GPBMetadata/Config/Proto/Screenshot.php";

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Screenshot\ScreenshotServiceClient;
use Screenshot\CaptureRequest;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:shared:screenshot',
    description: ''
)]
final class ScreenshotCommand extends Command
{
    public function __construct(
        #[Autowire('%grpc.hostname%')]
        protected string $grpcHostname,
        #[Autowire('%app.hostname%')]
        protected string $appHostname,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $client = new ScreenshotServiceClient($this->grpcHostname, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);

        $request = new CaptureRequest();
        $request->setUrl($this->appHostname);

        list($response, $status) = $client->CaptureScreenshot($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            echo "Error: " . $status->details . PHP_EOL;
            return Command::FAILURE;
        } else {
            file_put_contents(__DIR__ . './../../../../var/cache/screen.png', $response->getData());
        }

        return Command::SUCCESS;
    }
}
