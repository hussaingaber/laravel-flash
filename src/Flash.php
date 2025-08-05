<?php

declare(strict_types=1);

namespace GranadaPride\LaravelFlash;

class Flash
{
    protected array $messages = [];

    public function success($message, $title = null): Flash|static
    {
        return $this->message($message, 'success', $title);
    }

    public function error($message, $title = null): Flash|static
    {
        return $this->message($message, 'error', $title);
    }

    public function warning($message, $title = null): Flash|static
    {
        return $this->message($message, 'warning', $title);
    }

    public function info($message, $title = null): Flash|static
    {
        return $this->message($message, 'info', $title);
    }

    public function message($message, $type = 'info', $title = null): static
    {
        session()->flash('flash_messages', [
            'message' => $message,
            'type' => $type,
            'title' => $title,
        ]);

        return $this;
    }

    public function getMessages()
    {
        return session('flash_messages', []);
    }

    public function hasMessages(): bool
    {
        return session()->has('flash_messages');
    }

    public function overlay($message, $title = 'Notice', $type = 'info'): static
    {
        session()->flash('flash_messages', [
            'message' => $message,
            'type' => $type,
            'title' => $title,
            'overlay' => true,
        ]);

        return $this;
    }

    public function important(): static
    {
        $messages = session('flash_messages', []);
        $messages['important'] = true;
        session()->flash('flash_messages', $messages);

        return $this;
    }
}
